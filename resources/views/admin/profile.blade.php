<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <title>F1 Academy – Admin Profile</title>
</head>
<body>
@include('partials.navbar')

<div class="container mt-5 mb-5">
    <h2 class="text-white fw-bold mb-4">👤 Admin Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-md-5">
            <div class="card bg-dark border-danger p-4">
                <h5 class="text-white mb-3">Account Information</h5>
                <form method="POST" action="/admin/profile/update">
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
                        <label class="form-label text-secondary small">Login</label>
                        <input type="text" class="form-control bg-black text-white border-secondary" value="{{ $user->login }}" disabled>
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
                    <button type="submit" class="btn btn-danger w-100">Save Changes</button>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card bg-dark border-secondary p-4">
                <h5 class="text-white mb-3">⚙️ Account Settings</h5>
                <p class="text-secondary mb-1">Role: <span class="badge bg-danger">ADMIN</span></p>
                <p class="text-secondary mb-1">Login: <strong class="text-white">{{ $user->login }}</strong></p>
                <p class="text-secondary mb-1">Email: <strong class="text-white">{{ $user->email }}</strong></p>
                <p class="text-secondary mb-3">Member since: <strong class="text-white">{{ $user->created_at->format('d M Y') }}</strong></p>
                <hr class="border-secondary">
                <h6 class="text-white mb-2">Quick Links</h6>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="/admin/students" class="btn btn-outline-danger btn-sm">Manage Students</a>
                    <a href="/admin/courses" class="btn btn-outline-light btn-sm">Manage Courses</a>
                    <a href="/admin/managers" class="btn btn-outline-warning btn-sm">Manage Managers</a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>