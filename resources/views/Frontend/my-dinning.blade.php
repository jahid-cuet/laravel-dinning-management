@extends('Frontend.layouts.sidebar')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-2xl font-semibold text-blue-700 mb-6">My Dinning</h3>

    <p class="text-gray-600 mb-4">Showing <span class="font-bold">{{ $per_page }}</span> items per page</p>


    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
            <thead class="bg-blue-100 text-blue-800">
                <tr>
                    <th class="px-4 py-2 text-left">Serial</th>
                    <th class="px-4 py-2 text-left">Title</th>
                    <th class="px-4 py-2 text-left">Meal Rate</th>
                    <th class="px-4 py-2 text-left">Duration</th>
                    
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($months as $index => $month)
                    <tr>
                        <td class="px-4 py-2">{{ $months->firstItem() + $index }}</td>
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
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">No data available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="bg-white rounded-xl shadow mt-6 p-6">
    <h2 class="text-xl font-semibold text-blue-700 mb-4">Dining — {{ \Carbon\Carbon::parse($month->from)->format('F, Y') }}</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($period as $date)
            @php
                $formatted = $date->format('Y-m-d');
                $display = $date->format('d/m/Y');
                $meal = $meals[$formatted] ?? null;
            @endphp

            <div class="bg-white border border-gray-200 rounded-xl p-3 shadow text-center space-y-2">
                <div class="grid grid-cols-2 gap-2 items-center justify-center">
                    {{-- Lunch --}}
                    <div class="{{ $meal && $meal->lunch == 1 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }} px-3 py-1 rounded-full">
                        🍽️
                    </div>

                    {{-- Dinner --}}
                    <div class="{{ $meal && $meal->dinner == 1 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }} px-3 py-1 rounded-full">
                        🍽️
                    </div>
                </div>

                <div class="text-sm text-gray-700 font-medium">
                    {{ $display }}
                </div>
            </div>
        @endforeach
    </div>
</div>




  {{-- Pagination --}}
    <div class="mt-6">
        {{ $months->withQueryString()->links() }}
    </div>




@endsection
