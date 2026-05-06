<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <title>F1 Academy – Course Detail</title>
</head>
<body>
@include('partials.navbar')

<div class="container mt-5 mb-5">
    <a href="/manager" class="btn btn-outline-secondary btn-sm mb-4">← Back</a>

    <h2 class="text-white fw-bold mb-1">{{ $course->title }}</h2>
    <span class="badge mb-3
        @if($course->level == 'Beginner') bg-success
        @elseif($course->level == 'Advanced') bg-danger
        @else bg-warning text-dark @endif">
        {{ $course->level }}
    </span>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card bg-dark border-secondary p-4 mb-4">
                <h5 class="text-white mb-2">Description</h5>
                <p class="text-secondary">{{ $course->description ?? 'No description.' }}</p>
                <hr class="border-secondary">
                <div class="row">
                    <div class="col"><p class="text-secondary small mb-0">PRICE</p><p class="text-white fw-bold">${{ $course->price }}</p></div>
                    <div class="col"><p class="text-secondary small mb-0">STUDENTS</p><p class="text-white fw-bold">{{ $students->count() }}</p></div>
                    <div class="col"><p class="text-secondary small mb-0">CREATED</p><p class="text-white fw-bold">{{ $course->created_at->format('d M Y') }}</p></div>
                </div>
            </div>

            {{-- STUDENTS LIST --}}
            <div class="card bg-dark border-secondary p-4">
                <h5 class="text-white mb-3">👥 Enrolled Students</h5>
                @forelse($students as $student)
                <div class="d-flex justify-content-between align-items-center border-bottom border-secondary pb-2 mb-2">
                    <div>
                        <p class="text-white mb-0">{{ $student->full_name }}</p>
                        <small class="text-secondary">{{ $student->email }}</small>
                    </div>
                    <span class="badge bg-success">Active</span>
                </div>
                @empty
                <p class="text-secondary">No students enrolled yet.</p>
                @endforelse
            </div>
        </div>

        <div class="col-md-4">
            @if($course->file_path)
            <div class="card bg-dark border-secondary p-4">
                <h5 class="text-white mb-3">📄 Course File</h5>
                <a href="{{ asset('storage/' . $course->file_path) }}"
                   class="btn btn-outline-light w-100" target="_blank" download>
                    ⬇ Download Materials
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

@include('partials.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>