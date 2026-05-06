<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <title>F1 Academy – Student Home</title>
</head>
<body>
@include('partials.navbar')

<section class="hero d-flex justify-content-center align-items-center text-center">
    <div>
        <h1 class="display-3 fw-bold text-danger">Welcome back, {{ session('user_login') }}!</h1>
        <p class="text-secondary mb-4">Continue your motorsport journey.</p>
        <a href="/student/courses" class="btn btn-danger px-4 me-2">Browse Courses</a>
        <a href="/student/profile" class="btn btn-outline-light px-4">My Profile</a>
    </div>
</section>

<div class="container py-5">
    <h4 class="text-danger fw-bold mb-4 text-uppercase">Featured Courses</h4>
    <div class="row g-4">
        @forelse($courses as $course)
        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-3 h-100">
                <h5 class="text-danger">{{ $course->title }}</h5>
                <span class="badge mb-2
                    @if($course->level == 'Beginner') bg-success
                    @elseif($course->level == 'Advanced') bg-danger
                    @else bg-warning text-dark @endif">
                    {{ $course->level }}
                </span>
                <p class="text-secondary small flex-grow-1">{{ Str::limit($course->description, 80) }}</p>
                <p class="text-white fw-bold">${{ $course->price }}</p>
                <a href="/student/courses" class="btn btn-outline-danger btn-sm">View Details</a>
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