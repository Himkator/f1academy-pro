<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <title>F1 Academy – Admin</title>
</head>
<body>
@include('partials.navbar')

<div class="container mt-5 mb-5">
    <h2 class="text-white fw-bold mb-1">👑 Admin Dashboard</h2>
    <p class="text-secondary mb-4">System overview and statistics.</p>

    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <div class="card bg-dark border-danger p-3 text-center">
                <h3 class="text-danger fw-bold">{{ $totalStudents }}</h3>
                <p class="text-secondary mb-0">Students</p>
                <a href="/admin/students" class="btn btn-outline-danger btn-sm mt-2">Manage</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark border-warning p-3 text-center">
                <h3 class="text-warning fw-bold">{{ $totalManagers }}</h3>
                <p class="text-secondary mb-0">Managers</p>
                <a href="/admin/managers" class="btn btn-outline-warning btn-sm mt-2">Manage</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark border-secondary p-3 text-center">
                <h3 class="text-white fw-bold">{{ $totalCourses }}</h3>
                <p class="text-secondary mb-0">Courses</p>
                <a href="/admin/courses" class="btn btn-outline-light btn-sm mt-2">Manage</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark border-success p-3 text-center">
                <h3 class="text-success fw-bold">{{ $totalEnrolled }}</h3>
                <p class="text-secondary mb-0">Enrollments</p>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-3">
                <h5 class="text-white">👥 Students</h5>
                <p class="text-secondary small">View, edit and delete student accounts.</p>
                <a href="/admin/students" class="btn btn-outline-danger btn-sm">Go to Students</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-3">
                <h5 class="text-white">📚 Courses</h5>
                <p class="text-secondary small">Create, update and delete courses.</p>
                <a href="/admin/courses" class="btn btn-outline-light btn-sm">Go to Courses</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark border-secondary p-3">
                <h5 class="text-white">🛠 Managers</h5>
                <p class="text-secondary small">Manage managers and assign courses.</p>
                <a href="/admin/managers" class="btn btn-outline-warning btn-sm">Go to Managers</a>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>