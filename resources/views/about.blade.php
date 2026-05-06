<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <title>F1 Academy – About Us</title>
</head>
<body>
@include('partials.navbar')

<div class="container mt-5 mb-5">
    <h2 class="text-white fw-bold mb-4">🏎 About F1 Academy</h2>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card bg-dark border-secondary p-4 mb-4">
                <h4 class="text-danger mb-3">Our Mission</h4>
                <p class="text-secondary">F1 Academy is dedicated to providing world-class motorsport education to enthusiasts, aspiring engineers, and racing professionals. We bridge the gap between passion and expertise.</p>
            </div>

            <div class="card bg-dark border-secondary p-4 mb-4">
                <h4 class="text-danger mb-3">Our Goals</h4>
                <ul class="text-secondary">
                    <li class="mb-2">Deliver high-quality F1 education accessible to everyone</li>
                    <li class="mb-2">Connect students with industry professionals</li>
                    <li class="mb-2">Provide hands-on learning through real F1 data and simulations</li>
                    <li class="mb-2">Build a global community of motorsport enthusiasts</li>
                </ul>
            </div>

            <div class="card bg-dark border-secondary p-4">
                <h4 class="text-danger mb-3">Our Background</h4>
                <p class="text-secondary">Founded in 2020 by a team of ex-F1 engineers and educators, F1 Academy has grown to serve thousands of students worldwide. Our instructors bring decades of real-world experience from top F1 teams.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-dark border-danger p-4 mb-4">
                <h5 class="text-white mb-3">📊 By The Numbers</h5>
                <p class="text-secondary mb-1">🎓 <strong class="text-white">5,000+</strong> Students</p>
                <p class="text-secondary mb-1">📚 <strong class="text-white">50+</strong> Courses</p>
                <p class="text-secondary mb-1">👨‍🏫 <strong class="text-white">20+</strong> Instructors</p>
                <p class="text-secondary mb-0">🌍 <strong class="text-white">30+</strong> Countries</p>
            </div>

            <div class="card bg-dark border-secondary p-4">
                <h5 class="text-white mb-3">📬 Contact Us</h5>
                <p class="text-secondary mb-1">📧 info@f1academy.com</p>
                <p class="text-secondary mb-1">📞 +1 234 567 890</p>
                <p class="text-secondary mb-0">📍 Monaco, Monte Carlo</p>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>