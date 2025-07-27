@extends('Frontend.layouts.sidebar')

@section('content')
<div class="p-6">

    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-100 text-blue-800 p-4 rounded-xl">
            <div class="text-xl font-bold">{{ $totalMeals }}</div>
            <div class="text-sm">Today's Total Meals</div>
        </div>
        <div class="bg-purple-100 text-purple-800 p-4 rounded-xl">
            <div class="text-xl font-bold">{{ $totalLunch }}</div>
            <div class="text-sm">Today's Total Lunch</div>
        </div>
        <div class="bg-pink-100 text-pink-800 p-4 rounded-xl">
            <div class="text-xl font-bold">{{ $totalDinner }}</div>
            <div class="text-sm">Today's Total Dinner</div>
        </div>
    </div>

    <a href="{{ url()->previous() }}" class="mb-4 inline-block text-blue-600 hover:underline">← Back</a>

    <h2 class="text-2xl font-semibold mb-4">Daily Meal Details</h2>

    <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-sm text-gray-700 text-left">
                <tr>
                    <th class="px-4 py-3">Student</th>
                    <th class="px-4 py-3">Session</th>
                    <th class="px-4 py-3">Department</th>
                    <th class="px-4 py-3">Lunch</th>
                    <th class="px-4 py-3">Dinner</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-900">
                @foreach ($meals as $meal)
                    <tr class="border-b">
                        <td class="px-4 py-2">
                            {{ $meal->user->student_id ?? 'N/A' }}<br>
                            {{ $meal->user->name ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-2">{{ $meal->user->studentSession->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $meal->user->department->name ?? '-' }}</td>
                        <td class="px-4 py-2">
                            @if ($meal->lunch == 1)
                                <span class="text-green-600 font-semibold">Yes</span>
                            @else
                                <span class="text-red-600 font-semibold">No</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if ($meal->dinner == 1)
                                <span class="text-green-600 font-semibold">Yes</span>
                            @else
                                <span class="text-red-600 font-semibold">No</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
