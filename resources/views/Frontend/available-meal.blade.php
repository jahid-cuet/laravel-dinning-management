@extends('Frontend.layouts.sidebar')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif


    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-2xl font-semibold text-blue-700 mb-6">Available Dinning Meal</h3>

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
    <form method="POST" action="{{ route('pay') }}">
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
                            data-date="{{ $formatted }}" {{ $fullySelected ? 'checked disabled' : '' }}>
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
                💰 Total Payable: <span id="totalPayable" name="amount">0</span> ৳
            </div>

            <!-- Pass meal rate to JS -->
            <input type="hidden" id="mealRate" value="{{ $mealRate }}">
            <input type="hidden" name="meal_rate" value="{{ $mealRate }}">


        </div>
         {{-- <input type="hidden" value="100" name="amount" id="total_amount" required/> --}}

        <input type="hidden" name="dinning_month_id" value="{{ $month->id }}">

        <!-- Submit Button -->


<div class="text-center mt-8">
  <button class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white text-lg font-bold rounded-full shadow-lg flex items-center justify-center mx-auto transition duration-300 ease-in-out">
    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
      <path d="M4 3a1 1 0 000 2h.293l1.353 6.762a2 2 0 002.365 1.582l7.055-1.302a1 1 0 00.772-.972V5a1 1 0 00-1-1H5.618l-.276-1.447A1 1 0 004.366 2H4a1 1 0 00-1 1zm13 12a1 1 0 10-2 0 1 1 0 002 0zM8 17a1 1 0 100-2 1 1 0 000 2z"/>
    </svg>
    Pay Now
  </button>
</div>
    </form>

    <script>
        function updateMealCount() {
            const mealRate = parseFloat(document.getElementById('mealRate').value);
            let count = 0;

            document.querySelectorAll('.lunch-checkbox:checked:not(:disabled), .dinner-checkbox:checked:not(:disabled)')
                .forEach(() => count++);

            document.getElementById('mealCount').textContent = count;
            document.getElementById('totalPayable').textContent = (count * mealRate).toFixed(2);
        }

        // Update on master checkbox change
        document.querySelectorAll('.date-checkbox').forEach(dateCheckbox => {
            dateCheckbox.addEventListener('change', function() {
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




    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
@endsection
