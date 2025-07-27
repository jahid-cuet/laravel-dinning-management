@extends('Frontend.layouts.sidebar')

@section('content')
<div class="p-6">
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-100 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold">{{ $meals->sum('total_meals') }}</div>
            <div class="text-sm">Monthly Total Meals</div>
        </div>
        <div class="bg-purple-100 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold">{{ $meals->sum('total_lunch') }}</div>
            <div class="text-sm">Monthly Total Lunch</div>
        </div>
        <div class="bg-pink-100 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold">{{ $meals->sum('total_dinner') }}</div>
            <div class="text-sm">Monthly Total Dinner</div>
        </div>
    </div>

    <h2 class="text-xl font-bold mb-4">Monthly Meal Details</h2>

    <div class="bg-white shadow rounded-xl">
        <table class="w-full text-sm text-center">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Date</th>
                    <th class="p-2">Students</th>
                    <th class="p-2">Meals</th>
                    <th class="p-2">Lunch</th>
                    <th class="p-2">Dinner</th>
                    <th class="p-2">Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($meals as $meal)
                    <tr class="border-t">
                        <td class="p-2">{{ \Carbon\Carbon::parse($meal->meal_date)->format('d/m/Y') }}</td>
                        <td class="p-2">{{ $meal->students }}</td>
                        <td class="p-2">{{ $meal->total_meals }}</td>
                        <td class="p-2">{{ $meal->total_lunch }}</td>
                        <td class="p-2">{{ $meal->total_dinner }}</td>
                        <td class="p-2">
                    <a href="{{ route('student.daily-meal-details', ['date' => $meal->meal_date]) }}"
                    class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-100">
                        View Details
                    </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
