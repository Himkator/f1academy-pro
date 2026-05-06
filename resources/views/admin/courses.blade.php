<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <title>F1 Academy – Admin Courses</title>
</head>
<body>
@include('partials.navbar')

<div class="container mt-5 mb-5">
    <h2 class="text-white fw-bold mb-4">📚 Manage Courses</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- CREATE COURSE --}}
    <div class="card bg-dark border-secondary p-4 mb-5">
        <h5 class="text-white mb-3">➕ Create Course</h5>
        <form method="POST" action="/admin/courses/store" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-secondary small">Title</label>
                    <input type="text" name="title" class="form-control bg-black text-white border-secondary" required>
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
                    <input type="number" name="price" step="0.01" class="form-control bg-black text-white border-secondary">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-secondary small">Description</label>
                    <textarea name="description" rows="2" class="form-control bg-black text-white border-secondary"></textarea>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-secondary small">Assign Manager</label>
                    <select name="manager_id" class="form-select bg-black text-white border-secondary">
                        <option value="">No manager</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id }}">{{ $manager->login }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-secondary small">Course File</label>
                    <input type="file" name="course_file" class="form-control bg-black text-white border-secondary">
                </div>
            </div>
            <button type="submit" class="btn btn-danger mt-3">Create Course</button>
        </form>
    </div>

    {{-- COURSES TABLE --}}
    <div class="table-responsive">
        <table class="table table-dark table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Level</th>
                    <th>Price</th>
                    <th>Manager</th>
                    <th>Students</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                <tr>
                    <td>{{ $course->title }}</td>
                    <td><span class="badge
                        @if($course->level == 'Beginner') bg-success
                        @elseif($course->level == 'Advanced') bg-danger
                        @else bg-warning text-dark @endif">
                        {{ $course->level }}</span>
                    </td>
                    <td>${{ $course->price }}</td>
                    <td>{{ $course->user?->login ?? '—' }}</td>
                    <td>{{ $course->enrollments_count }}</td>
                    <td>
                        <form method="POST" action="/admin/courses/delete">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this course?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-secondary">No courses yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('partials.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>