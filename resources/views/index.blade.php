<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <title>F1 Academy - Main Page</title>
</head>
<body>

@include('partials.navbar')

{{-- HERO --}}
<section class="hero d-flex justify-content-center align-items-center text-center">
    <div>
        <h1 class="display-3 fw-bold text-danger">{{ __('messages.hero_title') }}</h1>
        <p class="text-secondary mb-4">{{ __('messages.hero_sub') }}</p>

        <div id="adBox" class="ad-box d-inline-block px-5 py-4 mb-4">
            🏁 &nbsp;{{ __('messages.discount') }}
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
            <button class="btn btn-outline-danger btn-sm" id="hideBtn">{{ __('messages.hide') }}</button>
            <button class="btn btn-outline-danger btn-sm" id="showBtn">{{ __('messages.show') }}</button>
            <button class="btn btn-outline-danger btn-sm" id="fadeInBtn">{{ __('messages.fade_in') }}</button>
            <button class="btn btn-outline-danger btn-sm" id="fadeOutBtn">{{ __('messages.fade_out') }}</button>
            <button class="btn btn-outline-danger btn-sm" id="fadeToBtn">{{ __('messages.fade_50') }}</button>
            <button class="btn btn-outline-danger btn-sm" id="slideUpBtn">{{ __('messages.slide_up') }}</button>
            <button class="btn btn-outline-danger btn-sm" id="slideDownBtn">{{ __('messages.slide_down') }}</button>
            <button class="btn btn-outline-danger btn-sm" id="animateBtn">{{ __('messages.animate') }}</button>
            <button class="btn btn-outline-light btn-sm" id="stopBtn">{{ __('messages.stop') }}</button>
        </div>
    </div>
</section>

{{-- CONSTRUCTORS CHART --}}
<section class="bg-black py-5 border-top border-secondary">
    <div class="container">
        <h4 class="text-danger text-center mb-4 text-uppercase fw-bold">
            {{ __('messages.constructors_title') }}
        </h4>
        <canvas id="BarChart"></canvas>
    </div>
</section>

{{-- ACADEMY STATS --}}
<section class="container py-5">
    <h4 class="text-danger text-center mb-4 text-uppercase fw-bold">
        {{ __('messages.academy_stats') }}
    </h4>
    <div class="row g-4">
        <div class="col-md-6"><canvas id="barChart"></canvas></div>
        <div class="col-md-6"><canvas id="pieChart"></canvas></div>
        <div class="col-md-6"><canvas id="polarChart"></canvas></div>
        <div class="col-md-6"><canvas id="lineChart"></canvas></div>
    </div>
</section>

{{-- FEATURED COURSES --}}
<section class="bg-black py-5 border-top border-secondary">
    <div class="container">
        <h4 class="text-danger text-center mb-4 text-uppercase fw-bold">
            Featured Courses
        </h4>
        <div class="row g-4">
            @forelse($courses as $course)
            <div class="col-md-4">
                <div class="card bg-dark border-secondary p-3 h-100 d-flex flex-column">
                    <h5 class="text-danger">{{ $course->title }}</h5>
                    <span class="badge mb-2
                        @if($course->level == 'Beginner') bg-success
                        @elseif($course->level == 'Advanced') bg-danger
                        @else bg-warning text-dark
                        @endif">
                        {{ $course->level }}
                    </span>
                    <p class="text-secondary small flex-grow-1">
                        {{ Str::limit($course->description, 80) }}
                    </p>
                    <p class="text-white fw-bold">${{ $course->price }}</p>
                    @if(session('user_role') == 'student')
                        <a href="/student/courses" class="btn btn-outline-danger btn-sm">View Details</a>
                    @else
                        <a href="/register" class="btn btn-outline-danger btn-sm">Enroll Now</a>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12">
                <p class="text-secondary text-center">No courses available yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="bg-black border-top border-secondary text-center py-5">
    <div class="container">
        <h2 class="text-white fw-bold mb-2">{{ __('messages.cta_title') }}</h2>
        <p class="text-secondary mb-4">{{ __('messages.cta_sub') }}</p>
        @if(!session('user_login'))
            <a href="/register" class="btn btn-danger px-4 me-2">{{ __('messages.register_now') }}</a>
            <a href="/login" class="btn btn-outline-light px-4">{{ __('messages.sign_in') }}</a>
        @else
            @if(session('user_role') == 'student')
                <a href="/student" class="btn btn-danger px-4">Go to Dashboard</a>
            @elseif(session('user_role') == 'manager')
                <a href="/manager" class="btn btn-danger px-4">Go to Dashboard</a>
            @elseif(session('user_role') == 'instructor')
                <a href="/instructor" class="btn btn-danger px-4">Go to Dashboard</a>
            @elseif(session('user_role') == 'admin')
                <a href="/admin" class="btn btn-danger px-4">Go to Dashboard</a>
            @endif
        @endif
    </div>
</section>

@include('partials.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/js/app.js"></script>
</body>
</html>