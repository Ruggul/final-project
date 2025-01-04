<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="ml-64 flex-1">
        @include('admin.components.header')
        
        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8">
            <!-- Document Management Section -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Document Management</h2>
                    <button onclick="openCreateModal()" 
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                        <i class="fas fa-plus mr-2"></i>New Document
                    </button>
                </div>

                <!-- Document List -->
                @if($documents->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 border-b">
                                    <th class="px-6 py-3 text-left">Title</th>
                                    <th class="px-6 py-3 text-left">Category</th>
                                    <th class="px-6 py-3 text-left">Created</th>
                                    <th class="px-6 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <i class="fas fa-file-alt text-gray-400 mr-3"></i>
                                                {{ $document->title }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 capitalize">{{ $document->category }}</td>
                                        <td class="px-6 py-4">{{ $document->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <button onclick="openEditModal({{ $document->id }})" 
                                                    class="text-blue-600 hover:text-blue-800 mx-1">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a href="{{ Storage::url($document->file_path) }}" 
                                               target="_blank"
                                               class="text-green-600 hover:text-green-800 mx-1">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <form action="{{ route('document.destroy', $document) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-800 mx-1">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $documents->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-file-alt text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500">No documents found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div id="documentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg p-8 max-w-md w-full">
                <h3 class="text-xl font-bold text-gray-800 mb-6" id="modalTitle">New Document</h3>
                <form id="documentForm" action="{{ route('document.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="methodField"></div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" id="title" 
                               class="w-full border rounded-lg px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category" id="category" 
                                class="w-full border rounded-lg px-3 py-2" required>
                            <option value="report">Report</option>
                            <option value="contract">Contract</option>
                            <option value="invoice">Invoice</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="description" 
                                  class="w-full border rounded-lg px-3 py-2"></textarea>
                    </div>

                    <div class="mb-6" id="fileInput">
                        <label class="block text-sm font-medium text-gray-700 mb-2">File</label>
                        <input type="file" name="file" class="w-full">
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()"
                                class="px-4 py-2 text-gray-600 hover:text-gray-800">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'New Document';
            document.getElementById('documentForm').action = "{{ route('document.store') }}";
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('fileInput').style.display = 'block';
            document.getElementById('documentModal').classList.remove('hidden');
        }

        function openEditModal(id) {
            document.getElementById('modalTitle').textContent = 'Edit Document';
            document.getElementById('documentForm').action = `/document-dashboard/${id}/update`;
            document.getElementById('methodField').innerHTML = '@method("PUT")';
            document.getElementById('fileInput').style.display = 'none';
            document.getElementById('documentModal').classList.remove('hidden');
            
            // Here you would typically fetch the document data and populate the form
        }

        function closeModal() {
            document.getElementById('documentModal').classList.add('hidden');
            document.getElementById('documentForm').reset();
        }
    </script>
</body>
</html>