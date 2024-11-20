@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Admin Dashboard</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('admin.edit-password', $user->id) }}" class="btn btn-primary btn-sm">Edit
                        Password</a>
                    <form action="{{ route('admin.delete-user', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                    <a href="{{ route('admin.login-as', $user->id) }}" class="btn btn-info btn-sm">Login As</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection