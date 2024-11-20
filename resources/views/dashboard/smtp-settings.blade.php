@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center" style="padding-top: 50px; background-color: #f8f9fa; min-height: 100vh;">
    <div class="container p-4 bg-white shadow rounded" style="max-width: 600px;">
        <h2 class="text-center mb-4">SMTP Settings</h2>

        <!-- Display Success Message -->
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- SMTP Settings Form -->
        <form action="{{ route('dashboard.smtp-settings') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="host" class="form-label">SMTP Host</label>
                <input type="text" name="host" id="host" class="form-control" value="{{ $settings->host ?? '' }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="port" class="form-label">SMTP Port</label>
                <input type="text" name="port" id="port" class="form-control" value="{{ $settings->port ?? '' }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">SMTP Username</label>
                <input type="text" name="username" id="username" class="form-control"
                    value="{{ $settings->username ?? '' }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">SMTP Password</label>
                <input type="password" name="password" id="password" class="form-control"
                    value="{{ $settings->password ?? '' }}" required>
            </div>

            <div class="mb-3">
                <label for="encryption" class="form-label">Encryption</label>
                <select name="encryption" id="encryption" class="form-control" required>
                    <option value="tls" {{ isset($settings) && $settings->encryption == 'tls' ? 'selected' : '' }}>TLS
                    </option>
                    <option value="ssl" {{ isset($settings) && $settings->encryption == 'ssl' ? 'selected' : '' }}>SSL
                    </option>
                    <option value="STARTTLS"
                        {{ isset($settings) && $settings->encryption == 'STARTTLS' ? 'selected' : '' }}>STARTTLS
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </div>
</div>
@endsection