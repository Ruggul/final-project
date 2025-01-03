<!DOCTYPE html>
<html>
<head>
    <title>Factory Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h3>Factory List</h3>
                <a href="{{ route('factories.create') }}" class="btn btn-primary">Add Factory</a>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($factories as $factory)
                            <tr>
                                <td>{{ $factory->name }}</td>
                                <td>{{ $factory->email }}</td>
                                <td>{{ $factory->phone }}</td>
                                <td>{{ $factory->address }}</td>
                                <td>
                                    <a href="{{ route('factories.edit', $factory->id) }}" 
                                       class="btn btn-warning btn-sm">Edit</a>
                                    <a href="{{ route('factories.show', $factory->id) }}" 
                                       class="btn btn-info btn-sm">View</a>
                                    <form action="{{ route('factories.destroy', $factory->id) }}" 
                                          method="POST" 
                                          style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Are you sure you want to delete this factory?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $factories->links() }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>