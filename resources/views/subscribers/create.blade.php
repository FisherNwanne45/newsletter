@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Subscriber List</h2>
    <form action="{{ route('subscriber.lists.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>List Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create List</button>
    </form>
</div>
@endsection