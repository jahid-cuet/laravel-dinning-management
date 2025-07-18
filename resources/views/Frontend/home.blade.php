<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dining Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col justify-center items-center">

    <!-- Header -->
    <header class="mb-12 text-center">
        <h1 class="text-4xl font-bold text-blue-700">Dining Management</h1>
        <p class="text-gray-600 mt-2">Manage your meals easily and efficiently</p>
    </header>

    <!-- Buttons -->
    <div class="space-x-6">
        <a href="{{route('register')}}">
            <button class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                Register
            </button>
        </a>
        <a href="{{route('user.login')}}">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg transition">
                Login
            </button>
        </a>
    </div>

</body>
</html>
