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
    <a href="/instructor" class="btn btn-outline-secondary btn-sm mb-4">← Back</a>

    <h2 class="text-white fw-bold mb-1">{{ $course->title }}</h2>
    <span class="badge mb-3
        @if($course->level == 'Beginner') bg-success
        @elseif($course->level == 'Advanced') bg-danger
        @else bg-warning text-dark @endif">
        {{ $course->level }}
    </span>

    <div class="row g-4">

        {{-- COURSE INFO --}}
        <div class="col-md-8">
            <div class="card bg-dark border-secondary p-4 mb-4">
                <h5 class="text-white mb-2">Course Information</h5>
                <p class="text-secondary">{{ $course->description ?? 'No description.' }}</p>
                <hr class="border-secondary">
                <div class="row">
                    <div class="col">
                        <p class="text-secondary small mb-0">PRICE</p>
                        <p class="text-white fw-bold">${{ $course->price }}</p>
                    </div>
                    <div class="col">
                        <p class="text-secondary small mb-0">STUDENTS</p>
                        <p class="text-white fw-bold">{{ $students->count() }}</p>
                    </div>
                    <div class="col">
                        <p class="text-secondary small mb-0">CREATED</p>
                        <p class="text-white fw-bold">{{ $course->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- STUDENTS WITH PROGRESS --}}
            <div class="card bg-dark border-secondary p-4">
                <h5 class="text-white mb-3">👥 Enrolled Students & Progress</h5>
                @forelse($students as $student)
                <div class="border-bottom border-secondary pb-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <p class="text-white mb-0 fw-bold">{{ $student->full_name }}</p>
                            <small class="text-secondary">{{ $student->email }}</small>
                        </div>
                        <span class="badge bg-success">Active</span>
                    </div>
                    {{-- Progress bar --}}
                    <label class="text-secondary small">Progress</label>
                    <div class="progress" style="height:8px;background:#1e1e1e;">
                        <div class="progress-bar bg-info"
                             style="width: {{ rand(20, 100) }}%">
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-secondary">No students enrolled yet.</p>
                @endforelse
            </div>
        </div>

        {{-- SIDE --}}
        <div class="col-md-4">
            {{-- FILE --}}
            <div class="card bg-dark border-secondary p-4 mb-3">
                <h5 class="text-white mb-3">📄 Course Materials</h5>
                @if($course->file_path)
                    <a href="{{ asset('storage/' . $course->file_path) }}"
                       class="btn btn-outline-light w-100" target="_blank" download>
                        ⬇ Download File
                    </a>
                @else
                    <p class="text-secondary small mb-0">No file uploaded.</p>
                @endif
            </div>

            {{-- MANAGEMENT TOOLS --}}
            <div class="card bg-dark border-info p-4">
                <h5 class="text-white mb-3">⚙️ Management Tools</h5>
                <p class="text-secondary small mb-3">Quick actions for this course.</p>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- EMAIL ALL STUDENTS --}}
                <form method="POST" action="/courses/{{ $course->id }}/email-students" class="mb-2">
                    @csrf
                    <button type="submit" class="btn btn-outline-info btn-sm w-100"
                            onclick="return confirm('Send email to all {{ $students->count() }} students?')">
                        📧 Email All Students
                    </button>
                </form>

                {{-- EXPORT PROGRESS --}}
                <a href="/courses/{{ $course->id }}/export"
                class="btn btn-outline-warning btn-sm w-100 mb-2">
                    📊 Export Progress (CSV)
                </a>

                {{-- DELETE COURSE (manager only, not instructor) --}}
                @if(session('user_role') == 'manager')
                <form method="POST" action="/manager/courses/delete">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <button class="btn btn-outline-danger btn-sm w-100"
                            onclick="return confirm('Delete this course?')">
                        🗑 Delete Course
                    </button>
                </form>
                @endif

            </div>
        </div>

    </div>
</div>

@include('partials.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>