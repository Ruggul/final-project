@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Create New Document</h2>
            <a href="{{ route('documents.index') }}" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            Please fix the following errors:
                        </p>
                        <ul class="mt-2 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <!-- Document Type -->
                <div>
                    <label for="document_type" class="block text-sm font-medium text-gray-700">Document Type</label>
                    <select name="document_type" id="document_type" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Document Type</option>
                        <option value="SOP">Standard Operating Procedure</option>
                        <option value="Manual">Manual Book</option>
                        <option value="Report">Report Document</option>
                        <option value="Form">Form Document</option>
                        <option value="Other">Other Document</option>
                    </select>
                </div>

                <!-- Document Name -->
                <div>
                    <label for="document_name" class="block text-sm font-medium text-gray-700">Document Name</label>
                    <input type="text" name="document_name" id="document_name" 
                           value="{{ old('document_name') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Document File -->
                <div>
                    <label for="document_file" class="block text-sm font-medium text-gray-700">Document File</label>
                    <input type="file" name="document_file" id="document_file" 
                           class="mt-1 block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                                  file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100">
                    <p class="mt-1 text-xs text-gray-500">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (max 2MB)</p>
                </div>

                <!-- Expiry Date -->
                <div>
                    <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                    <input type="date" name="expiry_date" id="expiry_date" 
                           value="{{ old('expiry_date') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="fas fa-save mr-2"></i>
                        Save Document
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection