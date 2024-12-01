@extends('layouts.app')

@section('content')
<style>
.cke_notification_warning {
    display: none !important;
}
</style>
<div class="d-flex justify-content-center" style="padding-top: 50px; background-color: #f8f9fa; min-height: 100vh;">
    <div class="container p-4 bg-white shadow rounded" style="max-width: 600px;">
        <h2 class="text-center mb-4">Create New Mail</h2>

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form id="newsletter-form" action="{{ route('newsletters.send') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Sender's Name Input -->
            <div class="form-group mb-4">
                <label for="sender_name">Sender's Name</label>
                <input type="text" id="sender_name" name="sender_name" class="form-control" required>
                <small class="form-text text-muted">This name will appear as the sender's name in the email.</small>
            </div>

            <div class="form-group mb-3">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" class="form-control" required>
            </div>

            <!-- CKEditor for Content -->
            <div class="form-group mb-3">
                <label for="content">Content</label>
                <textarea id="content" name="content" class="form-control" rows="5" required></textarea>
                <small class="form-text text-muted"><b>You can use shortcodes for personalized content in emails</b><br>
                    e.g. <i>Hello [name], you are registered with [email]</i></small>
            </div>

            <!-- Attachment -->
            <div class="form-group mb-3">
                <label for="attachment">Attachment (Optional)</label>
                <input type="file" id="attachment" name="attachment" class="form-control"
                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                <small class="form-text text-muted">You can attach an image, PDF, or MS Word document.</small>
            </div>

            <!-- Choose whether to send to new subscriber or from an existing list -->
            <div class="form-group mb-4">
                <label for="send_option">Send To</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="send_option" id="new_subscriber" value="new"
                        checked>
                    <label class="form-check-label" for="new_subscriber">
                        Send to a New Recipient Email
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="send_option" id="subscription_list" value="list">
                    <label class="form-check-label" for="subscription_list">
                        Send to an Email List
                    </label>
                </div>
            </div>

            <!-- Field for new subscriber's email -->
            <div class="form-group mb-3" id="new_subscriber_email" style="display: block;">
                <label for="new_subscriber_email_input">Recipient Email</label>
                <input type="email" id="new_subscriber_email_input" name="new_subscriber_email" class="form-control"
                    placeholder="Enter email address" />
            </div>

            <!-- Subscription List Selector -->
            <div class="form-group mb-4" id="subscription_list_selector" style="display: none;">
                <label for="subscription_list_id">Email List</label>
                <select id="subscription_list_id" name="subscription_list_id" class="form-control">
                    <option value="">Select an Email List</option>
                    @foreach($subscriptionLists as $list)
                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Send Newsletter</button>
        </form>
    </div>
</div>

<!-- Updated CKEditor Script (Version 4.25.0) -->
<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Attach CKEditor to the 'content' textarea
    CKEDITOR.replace('content', {
        toolbar: [{
                name: 'basicstyles',
                items: ['Bold', 'Italic', 'Underline', 'Strike']
            },
            {
                name: 'paragraph',
                items: ['NumberedList', 'BulletedList']
            },
            {
                name: 'styles',
                items: ['Format', 'FontSize']
            },
            {
                name: 'colors',
                items: ['TextColor', 'BGColor']
            },
            {
                name: 'insert',
                items: ['Link', 'Unlink']
            },
        ]
    });

    const newSubscriberRadio = document.getElementById("new_subscriber");
    const subscriptionListRadio = document.getElementById("subscription_list");
    const newSubscriberEmailField = document.getElementById("new_subscriber_email");
    const subscriptionListField = document.getElementById("subscription_list_selector");

    newSubscriberRadio.addEventListener("change", function() {
        if (newSubscriberRadio.checked) {
            newSubscriberEmailField.style.display = "block";
            subscriptionListField.style.display = "none";
        }
    });

    subscriptionListRadio.addEventListener("change", function() {
        if (subscriptionListRadio.checked) {
            newSubscriberEmailField.style.display = "none";
            subscriptionListField.style.display = "block";
        }
    });

    // Initially display the correct form field
    if (newSubscriberRadio.checked) {
        newSubscriberEmailField.style.display = "block";
        subscriptionListField.style.display = "none";
    } else {
        newSubscriberEmailField.style.display = "none";
        subscriptionListField.style.display = "block";
    }
});
</script>
@endsection