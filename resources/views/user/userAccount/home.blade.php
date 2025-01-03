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
    <!-- Navbar -->
    <nav class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/redirect') }}" class="flex items-center">
                <img src="{{ asset('design/tradeGateLogo.png') }}" alt="Logo" 
                     class="h-8 filter brightness-0 invert">
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Top Up History</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(count($topups) > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-4">Transaction No.</th>
                            <th class="text-center py-4">Amount</th>
                            <th class="text-center py-4">Payment Method</th>
                            <th class="text-center py-4">Status</th>
                            <th class="text-center py-4">Payment Date</th>
                            <th class="text-center py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topups as $topup)
                            <tr class="border-b">
                                <td class="py-4">
                                    {{ $topup->transaction_number }}
                                </td>
                                <td class="text-center py-4">
                                    $ {{ number_format($topup->amount, 2) }}
                                </td>
                                <td class="text-center py-4">
                                    <div class="flex flex-col">
                                        <span class="font-medium">
                                            @if($topup->payment_method == 'bank_transfer')
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                                    Bank Transfer
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">
                                                    E-Wallet
                                                </span>
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center py-4">
                                    <span class="px-2 py-1 rounded-full text-sm
                                        {{ $topup->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($topup->status == 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($topup->status) }}
                                    </span>
                                </td>
                                <td class="text-center py-4">
                                    {{ $topup->payment_date ? $topup->payment_date->format('M d, Y H:i') : '-' }}
                                </td>
                                <td class="text-center py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('topups.show', $topup->id) }}" 
                                           class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($topup->status == 'pending')
                                            <form action="{{ route('topups.cancel', $topup->id) }}" 
                                                  method="POST" 
                                                  class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-800"
                                                        onclick="return confirm('Are you sure you want to cancel this top up?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('topups.create') }}" 
                       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        <i class="fas fa-plus mr-2"></i>New Top Up
                    </a>

                    <div class="text-right">
                        <p class="text-lg font-bold">Total Balance: $ {{ number_format($totalBalance ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <p class="text-gray-500 mb-4">No top up records found</p>
                <a href="{{ route('topups.create') }}" 
                   class="text-green-600 hover:text-green-700">
                    Create New Top Up
                </a>
            </div>
        @endif
    </div>
</body>
</html>