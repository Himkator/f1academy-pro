<nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-danger">
    <div class="container">
        <a class="navbar-brand fw-bold text-danger" href="/">F1 Academy</a>
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                @if(session('user_role') == 'student')
                    <li class="nav-item"><a class="nav-link text-light" href="/student">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="/student/courses">Courses</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="/student/about">About</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="/student/profile">Profile</a></li>

                @elseif(session('user_role') == 'manager')
                    <li class="nav-item"><a class="nav-link text-light" href="/manager">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="/manager/about">About</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="/manager/profile">Profile</a></li>

                @elseif(session('user_role') == 'instructor')
                    <li class="nav-item"><a class="nav-link text-light" href="/instructor">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="/instructor/about">About</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="/instructor/profile">Profile</a></li>

                @elseif(session('user_role') == 'admin')
                    <li class="nav-item"><a class="nav-link text-light" href="/admin">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="/admin/students">Students</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="/admin/courses">Courses</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="/admin/staff">Managers & Instructors</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="/admin/profile">Profile</a></li>

                @else
                    <li class="nav-item"><a class="nav-link text-light" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="/about">About</a></li>
                @endif

            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                @if(session('user_login'))
                    <li class="nav-item">
                        <span class="nav-link text-light">
                            {{ session('user_login') }}
                            <span class="badge ms-1
                                @if(session('user_role') == 'admin') bg-danger
                                @elseif(session('user_role') == 'manager') bg-warning text-dark
                                @elseif(session('user_role') == 'instructor') bg-info text-dark
                                @elseif(session('user_role') == 'student') bg-success
                                @endif">
                                {{ strtoupper(session('user_role')) }}
                            </span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="/logout">Logout</a>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link text-light" href="/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link text-danger fw-bold" href="/register">Register</a></li>
                @endif
                <li class="nav-item">
                    <div class="d-flex gap-1 ms-lg-2 mt-1 mt-lg-0">
                        <a href="/language/en" class="btn btn-sm {{ app()->getLocale() == 'en' ? 'btn-danger' : 'btn-outline-secondary' }}">EN</a>
                        <a href="/language/ru" class="btn btn-sm {{ app()->getLocale() == 'ru' ? 'btn-danger' : 'btn-outline-secondary' }}">RU</a>
                        <a href="/language/kk" class="btn btn-sm {{ app()->getLocale() == 'kk' ? 'btn-danger' : 'btn-outline-secondary' }}">KK</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>