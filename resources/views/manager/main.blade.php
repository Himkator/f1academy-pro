<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <title>F1 Academy – Manager</title>
</head>
<body>
@include('partials.navbar')

<div class="container mt-5 mb-5">
    <h2 class="text-white fw-bold mb-1">Welcome, {{ session('user_login') }}!</h2>
    <p class="text-secondary mb-4">Manage your F1 Academy courses.</p>

    {{-- STATS --}}
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="card bg-dark border-danger p-3 text-center">
                <h3 class="text-danger fw-bold">{{ $courses->count() }}</h3>
                <p class="text-secondary mb-0">My Courses</p>
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
                <h3 class="text-white fw-bold">🏁</h3>
                <p class="text-secondary mb-0">Active Manager</p>
            </div>
        </div>
    </div>

    {{-- ADD COURSE --}}
    <div class="card bg-dark border-secondary p-4 mb-5">
        <h5 class="text-white mb-3">➕ Add New Course</h5>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="/manager/courses/store" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-secondary small">Title</label>
                    <input type="text" name="title"
                        class="form-control bg-black text-white border-secondary" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-secondary small">Level</label>
                    <select name="level" class="form-select bg-black text-white border-secondary">
                        <option>Beginner</option>
                        <option>Intermediate</option>
                        <option>Advanced</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-secondary small">Price ($)</label>
                    <input type="number" name="price" step="0.01"
                        class="form-control bg-black text-white border-secondary">
                </div>
                <div class="col-md-8">
                    <label class="form-label text-secondary small">Description</label>
                    <textarea name="description" rows="2"
                            class="form-control bg-black text-white border-secondary"></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-secondary small">Course File</label>
                    <input type="file" name="course_file"
                        class="form-control bg-black text-white border-secondary">
                </div>

                {{-- INSTRUCTOR DROPDOWN --}}
                <div class="col-md-6">
                    <label class="form-label text-secondary small">Assign Instructor</label>
                    <select name="instructor_id"
                            class="form-select bg-black text-white border-secondary">
                        <option value="">— No instructor —</option>
                        @forelse($instructors as $instructor)
                            <option value="{{ $instructor->id }}">
                                {{ $instructor->full_name }} ({{ $instructor->login }})
                            </option>
                        @empty
                            <option disabled>No instructors available</option>
                        @endforelse
                    </select>
                    <small class="text-secondary">Instructor will be able to see and manage this course.</small>
                </div>

            </div>
            <button type="submit" class="btn btn-danger mt-3">Add Course</button>
        </form>
    </div>

    {{-- MY COURSES --}}
    <h5 class="text-white mb-3">📚 My Courses</h5>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-dark table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Level</th>
                <th>Price</th>
                <th>Instructor</th>
                <th>Students</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
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
                <td>
                    @if($course->instructor)
                        <span class="badge bg-info text-dark">
                            {{ $course->instructor->login }}
                        </span>
                    @else
                        <span class="text-secondary small">Not assigned</span>
                    @endif
                </td>
                <td>{{ $course->enrollments_count }}</td>
                <td class="d-flex gap-2">
                    <a href="/manager/courses/{{ $course->id }}"
                    class="btn btn-outline-light btn-sm">Details</a>
                    <form method="POST" action="/manager/courses/delete">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this course?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-secondary">No courses yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    </div>
</div>

@include('partials.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>