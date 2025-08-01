<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dining Dashboard - CUET</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md p-5">
            <div class="text-center mb-8">
                <img src="https://1.bp.blogspot.com/-cCNYariHpyE/XVQ-BS7sG3I/AAAAAAAACew/EgTPlvajRMw263ZU3fJUWeaj9mUW7LkCQCLcBGAs/s1600/cuetlogo.png" alt="CUET Logo" class="h-12 mx-auto mb-2">
                <h1 class="text-xl font-bold text-blue-700">CUET</h1>
            </div>

@php
    $currentRoute = Route::currentRouteName();
@endphp

<nav class="space-y-2">
    <a href="{{ route('student.dashboard') }}"
       class="block px-4 py-2 rounded {{ $currentRoute == 'student.dashboard' ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-gray-200' }}">
        Dashboard
    </a>

    {{-- <a href="#"
       class="block px-4 py-2 rounded hover:bg-gray-200">
        Profile
    </a> --}}

    <a href="{{ route('student.select-meals.index') }}"
       class="block px-4 py-2 rounded {{ $currentRoute == 'student.select-meals.index' ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-gray-200' }}">
        Available Dinning Meal
    </a>

    <a href="{{ route('student.my-dinning') }}"
       class="block px-4 py-2 rounded {{ $currentRoute == 'student.my-dinning' ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-gray-200' }}">
        My Dinning
    </a>

    <a href="{{ route('student.refund-request.index') }}"
       class="block px-4 py-2 rounded {{ $currentRoute == 'student.refund-request.index' ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-gray-200' }}">
        Refund request
    </a>


    @php
    $hasDinningMonth = \App\Models\DinningMonth::where('user_id', auth()->id())->exists();
@endphp

    @if ($hasDinningMonth)
        <a href="{{ route('student.monthly-meal-details') }}"
           class="block px-4 py-2 rounded {{ $currentRoute == 'student.monthly-meal-details' ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-gray-200' }}">
            Monthly Meal Details
        </a>
    @endif



        <a href="{{ route('student.payment-history') }}"
       class="block px-4 py-2 rounded {{ $currentRoute == 'student.payment-history' ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-gray-200' }}">
        Payment History
    </a>
    
</nav>

            <div class="mt-10">
                <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 rounded bg-red-100 text-red-600 hover:bg-red-200">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-50">
            @yield('content')
        </main>
    </div>

</body>
</html>
