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
                <div>
                    <a href="{{ route('topups.create') }}" 
                       class="bg-white text-green-600 px-4 py-2 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-plus mr-2"></i>New Top Up
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8">
            <!-- Create Top Up Form -->
            @if(request()->routeIs('topups.create'))
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-bold mb-6">Create New Top Up</h2>
                    <form action="{{ route('topups.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Amount ($)</label>
                                <input type="number" name="amount" 
                                       class="w-full border rounded-lg px-3 py-2" 
                                       required min="1" step="0.01">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                                <select name="payment_method" class="w-full border rounded-lg px-3 py-2" required>
                                    <option value="">Select payment method</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="e-wallet">E-Wallet</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" 
                                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                                Process Top Up
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Top Up History -->
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
                                    <th class="text-center py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topups as $topup)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3">
                                            <a href="{{ route('topups.show', $topup) }}" 
                                               class="text-blue-600 hover:text-blue-800">
                                                {{ $topup->transaction_number }}
                                            </a>
                                        </td>
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
                                        <td class="text-center py-3">
                                            {{ $topup->payment_date ? $topup->payment_date->format('M d, Y H:i') : '-' }}
                                        </td>
                                        <td class="text-center py-3">
                                            <div class="flex justify-center space-x-2">
                                                <!-- View Details -->
                                                <a href="{{ route('topups.show', $topup) }}" 
                                                   class="text-blue-600 hover:text-blue-800"
                                                   title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                @if($topup->status === 'pending')
                                                    <!-- Upload Payment Proof -->
                                                    <form action="{{ route('topups.verify', $topup) }}" 
                                                          method="POST" 
                                                          enctype="multipart/form-data"
                                                          class="inline">
                                                        @csrf
                                                        <input type="file" 
                                                               name="payment_proof" 
                                                               class="hidden" 
                                                               id="proof{{ $topup->id }}"
                                                               accept="image/*"
                                                               onchange="this.form.submit()">
                                                        <label for="proof{{ $topup->id }}"
                                                               class="text-green-600 hover:text-green-800 cursor-pointer"
                                                               title="Upload Payment Proof">
                                                            <i class="fas fa-upload"></i>
                                                        </label>
                                                    </form>

                                                    <!-- Cancel TopUp -->
                                                    <form action="{{ route('topups.cancel', $topup) }}" 
                                                          method="POST" 
                                                          class="inline"
                                                          onsubmit="return confirm('Are you sure you want to cancel this top up?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-800"
                                                                title="Cancel">
                                                            <i class="fas fa-times-circle"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
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
                    <div class="text-center py-8">
                        <div class="mb-4">
                            <i class="fas fa-coins text-gray-400 text-5xl"></i>
                        </div>
                        <p class="text-gray-500 mb-4">No top up records found</p>
                        <a href="{{ route('topups.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            <i class="fas fa-plus mr-2"></i>
                            Make Your First Top Up
                        </a>
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
</body>
</html>