@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center" style="padding-top: 50px; background-color: #f8f9fa; min-height: 100vh;">
    <div class="container p-4 bg-white shadow rounded" style="max-width: 600px;">
        <h2 class="text-center mb-4">Edit Subscription List: {{ $list->name }}</h2>

        <!-- Edit Subscription List Form -->
        <form action="{{ route('subscribers.updateList', $list->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">List Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $list->name }}" required>
                @error('name')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
            <a href="{{ route('subscribers.index') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
</div>
@endsection