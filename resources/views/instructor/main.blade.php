<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <title>F1 Academy – Instructor</title>
</head>
<body>
@include('partials.navbar')

<div class="container mt-5 mb-5">
    <h2 class="text-white fw-bold mb-1">Welcome, {{ session('user_login') }}!</h2>
    <p class="text-secondary mb-4">Here are the courses assigned to you.</p>

    {{-- STATS --}}
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="card bg-dark border-info p-3 text-center">
                <h3 class="text-info fw-bold">{{ $courses->count() }}</h3>
                <p class="text-secondary mb-0">Assigned Courses</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-3 text-center">
                <h3 class="text-white fw-bold">{{ $courses->sum('enrollments_count') }}</h3>
                <p class="text-secondary mb-0">Total Students</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-3 text-center">
                <h3 class="text-white fw-bold">🏎</h3>
                <p class="text-secondary mb-0">Active Instructor</p>
            </div>
        </div>
    </div>

    {{-- ASSIGNED COURSES --}}
    <h5 class="text-white mb-3">📚 My Assigned Courses</h5>

    @if($courses->isEmpty())
        <div class="alert alert-secondary">
            You have no courses assigned yet. Please contact your manager.
        </div>
    @else
    <div class="table-responsive">
        <table class="table table-dark table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Level</th>
                    <th>Price</th>
                    <th>Students</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr>
                    <td>{{ $course->title }}</td>
                    <td>
                        <span class="badge
                            @if($course->level == 'Beginner') bg-success
                            @elseif($course->level == 'Advanced') bg-danger
                            @else bg-warning text-dark @endif">
                            {{ $course->level }}
                        </span>
                    </td>
                    <td>${{ $course->price }}</td>
                    <td>{{ $course->enrollments_count }}</td>
                    <td>
                        <a href="/instructor/courses/{{ $course->id }}"
                           class="btn btn-outline-info btn-sm">
                            View Details
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</div>

@include('partials.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>