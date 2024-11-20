<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $subject }}</title>
        <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e2e2e2;
        }

        .email-header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .email-body {
            padding: 20px;
        }

        .email-footer {
            background-color: #f1f1f1;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #777777;
        }

        .email-footer a {
            color: #007bff;
            text-decoration: none;
        }
        </style>
    </head>

    <body>

        <div class="email-container">
            <!-- Header with Sender's Name -->
            <div class="email-header">
                <h1> {{ $sender_name }}</h1>
            </div>

            <!-- Body of the Email -->
            <div class="email-body">
                <p>{{ $content }}</p>
            </div>

            <!-- Footer with Disclaimer and External Link -->
            <div class="email-footer">
                <p>This email is addressed in confidentiality to the recipient. If you no longer wish to receive these
                    emails, you can unsubscribe.</p>
                <p>&copy; {{ $sender_name }}. All Rights Reserved.</p>
                <p> <a href="#">Unsubscribe</a></p>
            </div>
        </div>

    </body>

</html>