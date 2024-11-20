<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Models\Subscriber;
use App\Models\SmtpSetting;
use App\Models\SubscriptionList;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Mail;


class NewsletterController extends Controller
{
    /**
     * Show form to create a new newsletter.
     */
    public function create()
    {
        $subscriptionLists = SubscriptionList::all();
        return view('newsletters.create', compact('subscriptionLists'));
    }

    /**
     * Store a new newsletter in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'subscription_list_id' => 'required|exists:subscription_lists,id'
        ]);

        Newsletter::create([
            'subject' => $request->input('subject'),
            'content' => $request->input('content'),
            'subscription_list_id' => $request->input('subscription_list_id'),
            'status' => 'draft'
        ]);

        return redirect()->route('newsletters.create')->with('success', 'Newsletter created successfully.');
    }

    /**
     * Send a newsletter to a new subscriber or all subscribers in a list.
     */
    
public function send(Request $request)
{
    $request->validate([
        'subject' => 'required|string|max:255',
        'content' => 'required|string',
        'sender_name' => 'required|string|max:255',
    ]);

    // Fetch SMTP settings from the database
    $smtpSettings = SmtpSetting::first();
    if (!$smtpSettings) {
        return redirect()->route('newsletters.create')->with('error', 'Please configure SMTP settings first.');
    }

    // Determine if sending to a single recipient or a subscription list
    $recipients = [];

    if ($request->input('send_option') == 'new') {
        // Sending to a new recipient (single email)
        $newRecipientEmail = $request->input('new_subscriber_email');
        $recipients[] = ['email' => $newRecipientEmail, 'name' => 'Recipient'];  // Default name is "Recipient"
    } elseif ($request->input('send_option') == 'list') {
        // Sending to an email list
        $subscriptionList = SubscriptionList::with('subscribers')->find($request->input('subscription_list_id'));
        if (!$subscriptionList || $subscriptionList->subscribers->isEmpty()) {
            return redirect()->route('newsletters.create')->with('error', 'No subscribers found in the selected list.');
        }
        $recipients = $subscriptionList->subscribers;
    }

    // Initialize counters and progress tracking
    $validEmailsCount = 0;
    $invalidEmailsCount = 0;
    $skipped = 0;
    $totalEmails = count($recipients);
    $progress = 0;

    session(['email_send_progress' => [
        'progress' => 0,
        'validEmails' => 0,
        'invalidEmails' => 0,
        'skipped' => 0,
        'totalEmails' => $totalEmails
    ]]);

    // Sender's name and email address from the form
    $senderName = $request->input('sender_name');
    $senderEmail = $smtpSettings->username;

    // Loop through all recipients
    foreach ($recipients as $recipient) {
        // Validate email format and check MX record
        if (!filter_var($recipient['email'], FILTER_VALIDATE_EMAIL) || !checkdnsrr(substr(strrchr($recipient['email'], "@"), 1), 'MX')) {
            $skipped++;
            $invalidEmailsCount++;
            session(['email_send_progress' => [
                'progress' => ++$progress,
                'validEmails' => $validEmailsCount,
                'invalidEmails' => $invalidEmailsCount,
                'skipped' => $skipped,
                'totalEmails' => $totalEmails
            ]]);
            continue;
        }

        // Personalize the content (replace [name] with recipient's name)
        $personalizedContent = str_replace('[name]', $recipient['name'], $request->input('content'));
        $personalizedContent = str_replace('[email]', $recipient['email'], $personalizedContent);

        try {
            // Create a new PHPMailer instance and configure SMTP settings
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $smtpSettings->host;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpSettings->username;
            $mail->Password = $smtpSettings->password;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $smtpSettings->port;

            // Set the sender's information
            $mail->setFrom($senderEmail, $senderName);
            $mail->addAddress($recipient['email'], $recipient['name']);
            $mail->Subject = $request->input('subject');

            // Use the Blade view to render the HTML email template
            $mail->isHTML(true);
            $mail->Body = view('emails.newsletter', [
                'sender_name' => $senderName,
                'content' => $personalizedContent,
                'subject' => $request->input('subject')
            ])->render();

            // Send the email
            $mail->send();
            $validEmailsCount++;
        } catch (Exception $e) {
            // Log the error if sending fails
            Log::error('Error sending email to ' . $recipient['email'] . ': ' . $e->getMessage());
        }

        // Update progress after sending each email
        $progress++;
        session(['email_send_progress' => [
            'progress' => $progress,
            'validEmails' => $validEmailsCount,
            'invalidEmails' => $invalidEmailsCount,
            'skipped' => $skipped,
            'totalEmails' => $totalEmails
        ]]);
    }

    // Final success message after sending all emails
    return redirect()->route('newsletters.create')->with('success', 
        "Newsletter sent successfully. $validEmailsCount emails sent, $invalidEmailsCount emails skipped.");
}


public function getProgress()
{
    // Return current progress from the session
    $progress = session('email_send_progress', [
        'progress' => 0,
        'validEmails' => 0,
        'invalidEmails' => 0,
        'skipped' => 0,
        'totalEmails' => 0
    ]);
    return response()->json($progress);
}



    /**
     * Display all newsletters.
     */
    public function index()
    {
        $newsletters = Newsletter::with('subscriptionList')->get();
        return view('newsletters.index', compact('newsletters'));
    }

    /**
     * Delete a newsletter.
     */
    public function destroy($id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->delete();

        return redirect()->route('newsletters.index')->with('success', 'Newsletter deleted successfully.');
    }
}