<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            <!-- Balance & Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Balance Card -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg text-gray-600">Available Balance</h3>
                        <i class="fas fa-wallet text-green-600 text-xl"></i>
                    </div>
                    <p class="text-3xl font-bold text-gray-800 mb-2">${{ number_format($wallet->balance ?? 0, 2) }}</p>
                    <a href="{{ route('topups.create') }}" 
                       class="inline-block text-green-600 hover:text-green-700">
                        <i class="fas fa-plus-circle mr-1"></i> Add Money
                    </a>
                </div>

                <!-- Quick Top Up -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg text-gray-600 mb-4">Quick Top Up</h3>
                    <form action="{{ route('topups.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-3 gap-2 mb-4">
                            @foreach([10, 25, 50] as $amount)
                                <button type="submit" 
                                        name="amount" 
                                        value="{{ $amount }}"
                                        class="p-2 border rounded-lg hover:border-green-600 text-center">
                                    ${{ number_format($amount, 2) }}
                                </button>
                            @endforeach
                        </div>
                        <a href="{{ route('topups.create') }}" 
                           class="block text-center text-green-600 hover:text-green-700">
                            More Options
                        </a>
                    </form>
                </div>

                <!-- Recent Activity Summary -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg text-gray-600 mb-4">Recent Activity</h3>
                    @if(isset($recent_topups) && count($recent_topups) > 0)
                        <div class="space-y-3">
                            @foreach($recent_topups->take(3) as $topup)
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-medium text-gray-800">${{ number_format($topup->amount, 2) }}</p>
                                        <p class="text-sm text-gray-500">{{ $topup->created_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        {{ $topup->status == 'success' ? 'bg-green-100 text-green-800' : 
                                           ($topup->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                            'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($topup->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center">No recent activity</p>
                    @endif
                </div>
            </div>

            <!-- Top Up Section -->
            @if(request()->routeIs('topups.create'))
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Top Up</h2>
                    <form action="{{ route('topups.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Amount Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Amount</label>
                                <div class="grid grid-cols-3 gap-3 mb-4">
                                    @foreach([10, 25, 50, 100, 200, 500] as $amount)
                                        <button type="button"
                                                onclick="selectAmount({{ $amount }})"
                                                class="amount-btn p-3 border-2 rounded-lg hover:border-green-600">
                                            ${{ number_format($amount, 2) }}
                                        </button>
                                    @endforeach
                                </div>
                                <input type="number" 
                                       name="amount"
                                       id="customAmount"
                                       class="w-full border rounded-lg px-3 py-2"
                                       placeholder="Custom amount"
                                       min="1"
                                       step="0.01">
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                                <div class="space-y-3">
                                    @foreach(['bank_transfer', 'credit_card', 'e-wallet'] as $method)
                                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:border-green-600">
                                            <input type="radio" 
                                                   name="payment_method" 
                                                   value="{{ $method }}"
                                                   class="mr-3">
                                            <span class="capitalize">{{ str_replace('_', ' ', $method) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                                Continue to Payment
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Transaction History -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Transaction History</h2>
                    <a href="{{ route('topups.index') }}" 
                       class="text-green-600 hover:text-green-700">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                @if(isset($topups) && count($topups) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3">Date</th>
                                    <th class="text-left py-3">Transaction ID</th>
                                    <th class="text-left py-3">Method</th>
                                    <th class="text-right py-3">Amount</th>
                                    <th class="text-center py-3">Status</th>
                                    <th class="text-center py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topups as $topup)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3">{{ $topup->created_at->format('M d, Y') }}</td>
                                        <td class="py-3">
                                            <a href="{{ route('topups.show', $topup) }}" 
                                               class="text-blue-600 hover:text-blue-800">
                                                #{{ $topup->id }}
                                            </a>
                                        </td>
                                        <td class="py-3 capitalize">
                                            {{ str_replace('_', ' ', $topup->payment_method) }}
                                        </td>
                                        <td class="py-3 text-right">${{ number_format($topup->amount, 2) }}</td>
                                        <td class="py-3 text-center">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                                {{ $topup->status == 'success' ? 'bg-green-100 text-green-800' : 
                                                   ($topup->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                    'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($topup->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3 text-center">
                                            @if($topup->status === 'pending')
                                                <div class="flex justify-center space-x-2">
                                                    <form action="{{ route('topups.verify', $topup) }}" 
                                                          method="POST" 
                                                          enctype="multipart/form-data"
                                                          class="inline">
                                                        @csrf
                                                        <input type="file" 
                                                               name="payment_proof" 
                                                               id="proof{{ $topup->id }}"
                                                               class="hidden"
                                                               onchange="this.form.submit()">
                                                        <label for="proof{{ $topup->id }}"
                                                               class="text-green-600 hover:text-green-800 cursor-pointer"
                                                               title="Upload Payment Proof">
                                                            <i class="fas fa-upload"></i>
                                                        </label>
                                                    </form>

                                                    <form action="{{ route('topups.cancel', $topup) }}" 
                                                          method="POST"
                                                          class="inline"
                                                          onsubmit="return confirm('Are you sure?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="text-red-600 hover:text-red-800"
                                                                title="Cancel">
                                                            <i class="fas fa-times-circle"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($topups->hasPages())
                        <div class="mt-4">
                            {{ $topups->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <div class="mb-4">
                            <i class="fas fa-receipt text-gray-400 text-5xl"></i>
                        </div>
                        <p class="text-gray-500">No transactions found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" 
             role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed bottom-4 right-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" 
             role="alert">
            <p class="font-bold">Error</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <script>
        function selectAmount(amount) {
            document.getElementById('customAmount').value = amount;
            document.querySelectorAll('.amount-btn').forEach(btn => {
                btn.classList.remove('border-green-600');
            });
            event.target.closest('.amount-btn').classList.add('border-green-600');
        }
    </script>
</body>
</html>