<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - SKT Gaming Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="dark-theme">
    <main class="container py-5">
        <div class="m-panel">
            <h1 class="m-panel__title">Admin Dashboard</h1>
            <p class="text-secondary mb-4">Khu vuc quan tri tam thoi cho SKT Gaming Store.</p>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-main"><span>Dang xuat</span></button>
            </form>
        </div>
    </main>
</body>
</html>
