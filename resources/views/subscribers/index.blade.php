@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center" style="padding-top: 50px; background-color: #f8f9fa; min-height: 100vh;">
    <div class="container p-4 bg-white shadow rounded" style="max-width: 900px;">
        <h2 class="text-center mb-4">Email Lists</h2>

        <!-- Display Success or Error Message -->
        @if (session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
        @elseif (session('error'))
        <div class="alert alert-danger mb-3">
            {{ session('error') }}
        </div>
        @endif

        <!-- Import New Subscribers Button -->
        <a href="{{ route('subscribers.showImportForm') }}" class="btn btn-primary mb-4">
            <h4 class="mb-0">Import New Email List</h4>
        </a>

        <!-- Subscription Lists Section -->
        <h3 class="mb-4">Email Lists</h3>
        <table class="table table-bordered mb-4">
            <thead>
                <tr>
                    <th>List Name</th>
                    <th>Number of Users</th>
                    <th>View List</th>
                    <th>Edit Name</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptionLists as $list)
                <tr>
                    <td>{{ $list->name }}</td>
                    <td>{{ $list->subscribers_count }}</td> <!-- Display the subscriber count -->
                    <td>
                        <a href="{{ route('subscribers.showList', $list->id) }}" class="btn btn-info btn-sm">
                            View List
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('subscribers.editListName', $list->id) }}" class="btn btn-warning btn-sm">
                            Edit Name
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('subscribers.destroyList', $list->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Are you sure you want to delete this list and all its users?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection