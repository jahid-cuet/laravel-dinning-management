@extends('Frontend.layouts.sidebar')


@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
        {{ session('success') }}
    </div>
@endif


<div class="container mx-auto px-4">
    <form action="{{ route('student.refund-request.store') }}" method="POST">
        @csrf

        <h2 class="text-2xl font-bold mb-4 text-center">
            Refund Request - {{ $dinning_month->title }}
        </h2>

        <div class="bg-white rounded-xl shadow mt-6 p-6">
            <div class="grid grid-cols-3 gap-4 p-4 font-semibold text-center text-gray-700 bg-gray-100 rounded-t-xl">
                <div>Lunch</div>
                <div>Date</div>
                <div>Dinner</div>
            </div>

            @foreach ($dates as $date)
                @php
                    $carbon = \Carbon\Carbon::parse($date);
                    $formatted = $carbon->format('d M, Y');
                    $meal = $meals[$date] ?? ['lunch' => 0, 'dinner' => 0];
                @endphp

                <div class="grid grid-cols-3 gap-4 text-center border-b border-gray-200 py-3 items-center">
                    {{-- Lunch --}}
                    <div>
                        <label class="inline-block cursor-pointer">
                            <input type="checkbox" name="meals[{{ $date }}][lunch]"
                                   class="hidden peer"
                                   {{ $meal['lunch'] == 0 ? 'disabled' : '' }}>
                            <div class="bg-gray-100 text-gray-700 rounded-full px-3 py-1 shadow 
                                        hover:bg-blue-100 peer-checked:bg-blue-600 peer-checked:text-white font-semibold transition 
                                        {{ $meal['lunch'] == 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                🍽️ Lunch
                            </div>
                        </label>
                    </div>

                    {{-- Date --}}
                    <div class="text-gray-700 font-medium">{{ $formatted }}</div>

                    {{-- Dinner --}}
                    <div>
                        <label class="inline-block cursor-pointer">
                            <input type="checkbox" name="meals[{{ $date }}][dinner]"
                                   class="hidden peer"
                                   {{ $meal['dinner'] == 0 ? 'disabled' : '' }}>
                            <div class="bg-gray-100 text-gray-700 rounded-full px-3 py-1 shadow 
                                        hover:bg-blue-100 peer-checked:bg-blue-600 peer-checked:text-white font-semibold transition 
                                        {{ $meal['dinner'] == 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                🍽️ Dinner
                            </div>
                        </label>
                    </div>
                </div>
            @endforeach

            <div class="text-right mt-4 p-4 bg-gray-50 rounded shadow">
    <p class="text-lg font-semibold text-gray-800">
        Total Meals Selected: <span id="total-meals">0</span>
    </p>
    <p class="text-lg font-semibold text-gray-800">
        Refund Dinning Fee: <span id="total-payable">0</span> ৳
    </p>
</div>

        </div>

        <input type="hidden" name="dinning_month_id" value="{{ $dinning_month->id }}">

        <div class="text-center mt-6">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                Submit Refund Request
            </button>
        </div>
    </form>
</div>


<script>
    const mealRate = {{ $mealRate ?? 35 }}; // replace with your actual meal_rate value from controller

    function updateTotals() {
        let totalMeals = 0;

        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            if (checkbox.checked && !checkbox.disabled) {
                totalMeals += 1;
            }
        });

        document.getElementById('total-meals').textContent = totalMeals;
        document.getElementById('total-payable').textContent = totalMeals * mealRate;
    }

    // Bind to all lunch/dinner checkboxes
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateTotals);
    });

    // Initialize total if any meals already checked
    window.addEventListener('DOMContentLoaded', updateTotals);
</script>

@endsection
