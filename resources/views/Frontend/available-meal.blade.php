@extends('Frontend.layouts.sidebar')

@section('content')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
        {{ session('success') }}
    </div>
@endif


    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-2xl font-semibold text-blue-700 mb-6">Available Dinning Meal</h3>

        <p class="text-gray-600 mb-4">Showing <span class="font-bold">{{ $per_page }}</span> items per page</p>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                <thead class="bg-blue-100 text-blue-800">
                    <tr>
                        <th class="px-4 py-2 text-left">Title</th>
                        <th class="px-4 py-2 text-left">Meal Rate</th>
                        <th class="px-4 py-2 text-left">Duration</th>

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    {{-- @forelse ($months as $index => $month) --}}
                       @if ($month)
                           <tr>
                            {{-- <td class="px-4 py-2">{{ $months->firstItem() + $index }}</td> --}}
                            <td class="px-4 py-2">{{ $month->title }}</td>
                            <td class="px-4 py-2">{{ $month->meal_rate }}</td>
                            <td class="px-4 py-2">
                                @php
                                    $from = \Carbon\Carbon::parse($month->from);
                                    $to = \Carbon\Carbon::parse($month->to);
                                    $days = $from->diffInDays($to) + 1;
                                @endphp
                                {{ $days }} days ({{ $from->format('d M Y') }} - {{ $to->format('d M Y') }})
                            </td>
                        </tr>
                       @else
                            <tr>
                            <td colspan="5" class="px-4 py-2 text-center text-gray-500">No data available</td>
                        </tr>
                       @endif      
                   
                </tbody>
            </table>
        </div>
    </div>

    {{-- <form method="POST" action="{{ route('checkout') }}"> --}}
    <form method="POST" action="{{ route('student.select-meals.store') }}">
        @csrf

        <!-- Grid Header -->
        <div
            class="grid grid-cols-4 gap-4 bg-gray-100 p-4 rounded-t-xl shadow font-semibold text-center text-gray-700 text-sm">
            <div>Selected</div>
            <div>Lunch</div>
            <div>Date</div>
            <div>Dinner</div>
        </div>

        
        <!-- Grid Body -->


<div class="bg-white rounded-b-xl shadow">
    @foreach ($period as $date)
        @php
            $formatted = $date->toDateString();
            $displayDate = $date->format('d/m/Y');
            $meal = $meals[$formatted] ?? null;
            $lunchSelected = $meal && $meal->lunch;
            $dinnerSelected = $meal && $meal->dinner;
            $fullySelected = $lunchSelected && $dinnerSelected;
        @endphp

        <div class="grid grid-cols-4 gap-4 items-center p-4 border-t text-center">
            <!-- Selected Checkbox (controls lunch + dinner) -->
            <label class="inline-flex justify-center items-center">
                <input type="checkbox" class="form-checkbox h-5 w-5 text-purple-600 date-checkbox"
                    data-date="{{ $formatted }}"
                    {{ $fullySelected ? 'checked disabled' : '' }}>
            </label>

            <!-- Lunch 🍽 -->
            <label class="inline-flex justify-center items-center space-x-1 cursor-default">
                <input type="checkbox" name="meals[{{ $formatted }}][lunch]" value="1"
                    class="hidden lunch-checkbox" data-date="{{ $formatted }}"
                    {{ $lunchSelected ? 'checked disabled' : '' }}>
                <span class="text-indigo-600 text-xl select-none">🍽</span>
            </label>

            <!-- Date -->
            <span class="text-gray-800 font-medium">{{ $displayDate }}</span>

            <!-- Dinner 🍽 -->
            <label class="inline-flex justify-center items-center space-x-1 cursor-default">
                <input type="checkbox" name="meals[{{ $formatted }}][dinner]" value="1"
                    class="hidden dinner-checkbox" data-date="{{ $formatted }}"
                    {{ $dinnerSelected ? 'checked disabled' : '' }}>
                <span class="text-indigo-600 text-xl select-none">🍽</span>
            </label>
        </div>
    @endforeach

<div class="bg-gray-100 mt-4 p-4 rounded shadow text-right font-semibold text-gray-800">
    🍽️ Total Meals Selected: <span id="mealCount">0</span><br>
    💰 Total Payable: <span id="totalPayable">0</span> ৳
</div>

<!-- Pass meal rate to JS -->
<input type="hidden" id="mealRate" value="{{ $mealRate }}">

</div>

</div>


<input type="hidden" name="dinning_month_id" value="{{ $month->id }}">

        <!-- Submit Button -->
        <div class="text-center mt-8">
            <button type="submit"
                class="bg-blue-600 mb-4 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md">
                Pay Now
            </button>
        </div>
    </form>

<script>
    function updateMealCount() {
        const mealRate = parseFloat(document.getElementById('mealRate').value);
        let count = 0;

        document.querySelectorAll('.lunch-checkbox:checked:not(:disabled), .dinner-checkbox:checked:not(:disabled)').forEach(() => count++);

        document.getElementById('mealCount').textContent = count;
        document.getElementById('totalPayable').textContent = (count * mealRate).toFixed(2);
    }

    // Update on master checkbox change
    document.querySelectorAll('.date-checkbox').forEach(dateCheckbox => {
        dateCheckbox.addEventListener('change', function () {
            const date = this.dataset.date;
            const lunch = document.querySelector(`.lunch-checkbox[data-date="${date}"]`);
            const dinner = document.querySelector(`.dinner-checkbox[data-date="${date}"]`);

            lunch.checked = this.checked;
            dinner.checked = this.checked;

            updateMealCount();
        });
    });

    // Update when manually toggling hidden lunch/dinner checkboxes
    document.querySelectorAll('.lunch-checkbox, .dinner-checkbox').forEach(cb => {
        cb.addEventListener('change', updateMealCount);
    });

    // Initial load
    updateMealCount();
</script>


@endsection
