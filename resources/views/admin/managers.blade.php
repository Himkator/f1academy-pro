<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <title>F1 Academy – Managers</title>
</head>
<body>
@include('partials.navbar')

<div class="container mt-5 mb-5">
    <h2 class="text-white fw-bold mb-4">🛠 Managers</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ASSIGN MANAGER TO COURSE --}}
    <div class="card bg-dark border-secondary p-4 mb-5">
        <h5 class="text-white mb-3">Assign Manager to Course</h5>
        <form method="POST" action="/admin/managers/assign" class="row g-3">
            @csrf
            <div class="col-md-5">
                <label class="form-label text-secondary small">Manager</label>
                <select name="manager_id" class="form-select bg-black text-white border-secondary">
                    @foreach($managers as $manager)
                        <option value="{{ $manager->id }}">{{ $manager->login }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label text-secondary small">Course</label>
                <select name="course_id" class="form-select bg-black text-white border-secondary">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-danger w-100">Assign</button>
            </div>
        </form>
    </div>

    {{-- MANAGERS LIST --}}
    <div class="table-responsive">
        <table class="table table-dark table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Courses</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($managers as $manager)
                <tr>
                    <td>{{ $manager->id }}</td>
                    <td>{{ $manager->login }}</td>
                    <td>{{ $manager->email }}</td>
                    <td>{{ $manager->courses->count() }}</td>
                    <td>
                        <form method="POST" action="/admin/managers/delete">
                            @csrf
                            <input type="hidden" name="manager_id" value="{{ $manager->id }}">
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this manager?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-secondary">No managers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('partials.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>