@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center" style="padding-top: 50px; background-color: #f8f9fa; min-height: 100vh;">
    <div class="container p-4 bg-white shadow rounded" style="max-width: 600px;">
        <h2 class="text-center mb-4">Change Password</h2>

        <!-- Display success or error message -->
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf

            <!-- Current Password -->
            <div class="form-group mb-4">
                <label for="current_password">Current Password</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>

            <!-- New Password -->
            <div class="form-group mb-4">
                <label for="new_password">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>

            <!-- Confirm New Password -->
            <div class="form-group mb-4">
                <label for="new_password_confirmation">Confirm New Password</label>
                <input type="password" class="form-control" id="new_password_confirmation"
                    name="new_password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</div>
@endsection