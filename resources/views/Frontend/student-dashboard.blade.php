@extends('Frontend.layouts.sidebar')

@section('content')
@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
        {{ session('error') }}
    </div>
@endif


    {{-- <h2 class="text-2xl font-bold mb-6 text-gray-800">My Running Dining Meals</h2> --}}

<div class="grid grid-cols-1 sm:grid-cols-3 gap-8">

    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center space-y-3 border border-indigo-200 hover:shadow-lg transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18M3 14h18M3 18h18" />
        </svg>
        <p class="text-2xl font-semibold text-indigo-700 text-center">Welcome Back!</p>
        <p class="text-indigo-600 text-center">Hope you have a great day!</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center space-y-3 border border-green-200 hover:shadow-lg transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 8H7a2 2 0 01-2-2V7a2 2 0 012-2h3l2-2h4l2 2h3a2 2 0 012 2v9a2 2 0 01-2 2z" />
        </svg>
        <p class="text-2xl font-semibold text-green-700 text-center">Ready to Dine?</p>
        <p class="text-green-600 text-center">Check your meal schedule now.</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center space-y-3 border border-yellow-200 hover:shadow-lg transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-2xl font-semibold text-yellow-700 text-center">Have a Good Meal!</p>
        <p class="text-yellow-600 text-center">Enjoy your dining experience.</p>
    </div>

</div>

@endsection
