<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="ml-64 flex-1">
        @include('admin.components.header')
        
        <!-- Navbar -->
        <nav class="bg-green-600 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <a href="{{ url('/redirect') }}" class="flex items-center">
                    <img src="{{ asset('design/tradeGateLogo.png') }}" alt="Logo" class="h-8 filter brightness-0 invert">
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-6">Top Up History</h2>
                
                @if(isset($topups) && count($topups) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3">Transaction Number</th>
                                    <th class="text-right py-3">Amount</th>
                                    <th class="text-center py-3">Payment Method</th>
                                    <th class="text-center py-3">Status</th>
                                    <th class="text-center py-3">Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topups as $topup)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3">{{ $topup->transaction_number }}</td>
                                        <td class="text-right py-3">${{ number_format($topup->amount, 2) }}</td>
                                        <td class="text-center py-3">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                                {{ $topup->payment_method == 'bank_transfer' ? 'bg-blue-100 text-blue-800' : 
                                                   ($topup->payment_method == 'credit_card' ? 'bg-purple-100 text-purple-800' : 
                                                    'bg-green-100 text-green-800') }}">
                                                {{ str_replace('_', ' ', ucfirst($topup->payment_method)) }}
                                            </span>
                                        </td>
                                        <td class="text-center py-3">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                                {{ $topup->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($topup->status == 'success' ? 'bg-green-100 text-green-800' : 
                                                    'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($topup->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center py-3">{{ $topup->payment_date ? $topup->payment_date->format('M d, Y H:i') : '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($topups->hasPages())
                        <div class="mt-4">
                            {{ $topups->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>No top up records found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>