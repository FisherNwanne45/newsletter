@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center" style="padding-top: 50px; background-color: #f8f9fa; min-height: 100vh;">
    <div class="container p-4 bg-white shadow rounded" style="max-width: 900px;">
        <h1 class="text-center mb-4">Import Users</h1>

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

        <!-- Import Form -->
        <form action="{{ route('subscribers.import') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Select Subscription List -->
            <div class="form-group mb-4">
                <label for="list_id">Add to an existing List</label>
                <select name="list_id" id="list_id" class="form-control">
                    <option value="">-- Select List --</option>
                    @foreach ($subscriptionLists as $list)
                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                    @endforeach
                </select>
                @error('list_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- OR Add New List -->
            <div class="form-group mb-4">
                <label for="new_list_name">Or, Create a New List</label>
                <input type="text" name="new_list_name" id="new_list_name" class="form-control"
                    placeholder="Enter new list name">
                @error('new_list_name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Upload CSV or TXT File -->
            <div class="form-group mb-4">
                <label for="subscriber_file">Upload CSV or TXT File</label>
                <input type="file" name="subscriber_file" id="subscriber_file" class="form-control" accept=".csv, .txt"
                    required>
                @error('subscriber_file')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Import</button>
        </form>
    </div>
</div>
@endsection