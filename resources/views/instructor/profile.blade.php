<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <title>F1 Academy – Instructor Profile</title>
</head>
<body>
@include('partials.navbar')

<div class="container mt-5 mb-5">
    <h2 class="text-white fw-bold mb-4">👤 My Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-md-5">
            <div class="card bg-dark border-info p-4">
                <h5 class="text-white mb-3">Personal Information</h5>
                <form method="POST" action="/instructor/profile/update">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-secondary small">First Name</label>
                        <input type="text" name="first_name" class="form-control bg-black text-white border-secondary" value="{{ $user->first_name }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Last Name</label>
                        <input type="text" name="last_name" class="form-control bg-black text-white border-secondary" value="{{ $user->last_name }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Email</label>
                        <input type="text" class="form-control bg-black text-white border-secondary" value="{{ $user->email }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Phone</label>
                        <input type="text" name="phone" class="form-control bg-black text-white border-secondary" value="{{ $user->phone }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Bio</label>
                        <textarea name="bio" rows="3" class="form-control bg-black text-white border-secondary">{{ $user->bio }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-info text-dark fw-bold w-100">Save Changes</button>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card bg-dark border-secondary p-4">
                <h5 class="text-white mb-3">📚 My Courses</h5>
                @forelse($courses as $course)
                <div class="d-flex justify-content-between align-items-center border-bottom border-secondary pb-2 mb-2">
                    <div>
                        <p class="text-white mb-0 fw-bold">{{ $course->title }}</p>
                        <small class="text-secondary">{{ $course->level }} · ${{ $course->price }}</small>
                    </div>
                    <a href="/instructor/courses/{{ $course->id }}" class="btn btn-outline-info btn-sm">Details</a>
                </div>
                @empty
                <p class="text-secondary">No courses yet. <a href="/instructor" class="text-info">Create one →</a></p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@include('partials.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>