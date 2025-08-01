@extends('Frontend.layouts.sidebar') {{-- If you’re using a layout, otherwise remove this line --}}

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Your Payment History</h2>

    @if ($orders->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded">
            No payment records found.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded shadow">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Serial</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Date/Time</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Transaction ID</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Amount</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Status</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $index => $order)
                        <tr class="border-t">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $index + 1 }}</td>
                                                        <td class="px-4 py-2 text-sm text-gray-600">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</td>
                            <td class="px-4 py-2 text-sm text-blue-600">{{ $order->transaction_id }}</td>
                            <td class="px-4 py-2 text-sm text-green-600">{{ number_format($order->amount, 2) }} {{ $order->currency }}</td>

                             <td class="px-4 py-2 text-sm capitalize">
                                <span class="px-2 py-1 rounded 
                                    @if($order->status == 'Pending') bg-yellow-200 text-yellow-800 
                                    @elseif($order->status == 'Complete') bg-green-200 text-green-800 
                                    @else bg-red-200 text-red-800 
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
