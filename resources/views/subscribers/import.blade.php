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

            <!-- Toggle Between Add or Create -->
            <div class="form-group mb-4">
                <label>Select an Action:</label>
                <div>
                    <input type="radio" name="list_action" id="add_to_existing" value="existing" checked>
                    <label for="add_to_existing">Add to Existing List</label>
                </div>
                <div>
                    <input type="radio" name="list_action" id="create_new_list" value="new">
                    <label for="create_new_list">Create New List</label>
                </div>
            </div>

            <!-- Select Subscription List -->
            <div class="form-group mb-4" id="existing_list_group">
                <label for="list_id">Add to an Existing List</label>
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

            <!-- Create New List -->
            <div class="form-group mb-4 d-none" id="new_list_group">
                <label for="new_list_name">Create a New List</label>
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

<script>
// JavaScript to toggle fields based on radio button selection
document.addEventListener('DOMContentLoaded', function() {
    const addToExistingRadio = document.getElementById('add_to_existing');
    const createNewListRadio = document.getElementById('create_new_list');
    const existingListGroup = document.getElementById('existing_list_group');
    const newListGroup = document.getElementById('new_list_group');

    function toggleFields() {
        if (addToExistingRadio.checked) {
            existingListGroup.classList.remove('d-none');
            newListGroup.classList.add('d-none');
        } else {
            existingListGroup.classList.add('d-none');
            newListGroup.classList.remove('d-none');
        }
    }

    // Initial toggle state
    toggleFields();

    // Add event listeners to radio buttons
    addToExistingRadio.addEventListener('change', toggleFields);
    createNewListRadio.addEventListener('change', toggleFields);
});
</script>
@endsection