@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Email Lists</h2>

    <!-- Form to create a new subscription list -->
    <form action="{{ route('subscribers.storeSubscriptionList') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>List Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create List</button>
    </form>

    <!-- Display existing lists and their subscribers -->
    <h3>Existing Email Lists</h3>
    @foreach ($lists as $list)
    <h4>{{ $list->name }}</h4>
    <ul>
        @foreach ($list->subscribers as $subscriber)
        <li>{{ $subscriber->name }} ({{ $subscriber->email }})</li>
        @endforeach
    </ul>
    @endforeach

    <!-- Form to add a subscriber to a list -->
    <h4>Add User to List</h4>
    <form action="{{ route('subscribers.addSubscriberToList') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Email List</label>
            <select name="subscription_list_id" class="form-control">
                @foreach ($lists as $list)
                <option value="{{ $list->id }}">{{ $list->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>User</label>
            <select name="subscriber_id" class="form-control">
                @foreach ($subscribers as $subscriber)
                <option value="{{ $subscriber->id }}">{{ $subscriber->name }} - {{ $subscriber->email }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add User to List</button>
    </form>
</div>
@endsection