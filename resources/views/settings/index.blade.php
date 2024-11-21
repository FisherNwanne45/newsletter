@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center" style="padding-top: 50px; background-color: #f8f9fa; min-height: 100vh;">
    <div class="container p-4 bg-white shadow rounded" style="max-width: 600px;">

        <h2 class="text-center mb-4">Registration Settings</h2>

        <!-- Show success message if status was updated -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('settings.toggle') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="registration_enabled">Allow Registration</label><br>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="registration_enabled"
                        name="registration_enabled" value="1" {{ $registrationEnabled->value ? 'checked' : '' }}>
                    <label class="form-check-label" for="registration_enabled">Enable User Registration</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
        </form>
    </div>
</div>
@endsection