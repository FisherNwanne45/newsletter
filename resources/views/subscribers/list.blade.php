@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center" style="padding-top: 50px; background-color: #f8f9fa; min-height: 100vh;">
    <div class="container p-4 bg-white shadow rounded" style="max-width: 900px;">
        <h2 class="text-center mb-4">User List: {{ $list->name }}</h2>

        <!-- Subscribers Table -->
        <table class="table mb-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscribers as $subscriber)
                <tr>
                    <td>{{ $subscriber->name ?? 'N/A' }}</td>
                    <td>{{ $subscriber->email }}</td>
                    <td>{{ $subscriber->status }}</td>
                    <td>
                        <!-- Action buttons, e.g., delete subscriber -->
                        <form action="{{ route('subscribers.destroy', $subscriber->id) }}" method="POST"
                            class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Back Button -->
        <a href="{{ route('subscribers.index') }}" class="btn btn-secondary">Back to Lists</a>
    </div>
</div>
@endsection