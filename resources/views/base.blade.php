<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Book Rating System')</title>

    <!-- ✅ Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ✅ jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- ✅ Bootstrap Bundle JS (dengan Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>

    <!-- ✅ Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">📚 Book Rating</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-light">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Books</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/author') }}">Authors</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/rating') }}">Ratings</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ✅ Content Section -->
    <main class="container">
        @yield('content')
    </main>

    <!-- ✅ Footer -->
    <footer class="bg-primary text-light text-center ">
        <p class="mb-0">© {{ date('Y') }} Technical-test Book Rating System | I Ketut Divta Suryawan</p>
    </footer>

    @yield('scripts')

</body>
</html>
