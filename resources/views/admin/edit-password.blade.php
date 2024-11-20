@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Password for {{ $user->name }}</h2>

    <form action="{{ route('admin.update-password', $user->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div>
@endsection