@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="my-4">Dashboard</h1>

    <div class="row">
        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="card-title d-flex align-items-center">
                        <i class="fa fa-users fa-2x mr-3"></i>
                        &nbsp; <h5>{{ $totalSubscribers }}</h5>
                    </div>
                    <p>Total number of saved users.</p>
                    <a href="{{ route('subscribers.index') }}" class="btn btn-light">View Users</a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="card-title d-flex align-items-center">
                        <i class="fa fa-list-alt fa-2x mr-3"></i>
                        &nbsp; <h5>{{ $totalSubscriptionLists }}</h5>
                    </div>
                    <p>Total number of email lists.</p>
                    <a href="{{ route('subscribers.index') }}" class="btn btn-light">View Lists</a>
                </div>
            </div>
        </div>

        <!-- Card 3 
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="card-title d-flex align-items-center">
                        <i class="fa fa-paper-plane fa-2x mr-3"></i>
                        &nbsp; <h5>{{ $totalNewslettersSent }}</h5>
                    </div>
                    <p>Total number of newsletters sent.</p>
                    <a href="{{ route('newsletters.index') }}" class="btn btn-light">View Newsletters</a>
                </div>
            </div>
        </div>-->

        <!-- Card 4 -->
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="card-title d-flex align-items-center">
                        <i class="fa fa-cogs fa-2x mr-3"></i>
                        <h5>Configure SMTP</h5>
                    </div>
                    <p>SMTP settings for sending emails.</p>
                    <a href="{{ route('dashboard.smtp-settings') }}" class="btn btn-light">Manage Settings</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection