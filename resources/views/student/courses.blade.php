<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <title>F1 Academy – Courses</title>
</head>
<body>
@include('partials.navbar')

<div class="container mt-5 mb-5">
    <h2 class="text-white fw-bold mb-4">📚 Available Courses</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        @forelse($courses as $course)
        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-3 h-100 d-flex flex-column">
                <h5 class="text-danger">{{ $course->title }}</h5>
                <span class="badge mb-2
                    @if($course->level == 'Beginner') bg-success
                    @elseif($course->level == 'Advanced') bg-danger
                    @else bg-warning text-dark @endif">
                    {{ $course->level }}
                </span>
                <p class="text-secondary small flex-grow-1">{{ $course->description }}</p>
                <p class="text-white fw-bold">${{ $course->price }}</p>

                @if($course->file_path)
                    <a href="{{ asset('storage/' . $course->file_path) }}"
                       class="btn btn-outline-light btn-sm mb-2" target="_blank">
                        📄 View Materials
                    </a>
                @endif

                <form method="POST" action="/student/enroll">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <button type="submit" class="btn btn-danger btn-sm w-100">Enroll Now</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-secondary">No courses available yet.</p>
        @endforelse
    </div>
</div>

@include('partials.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>