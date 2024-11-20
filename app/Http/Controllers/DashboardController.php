<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Models\Subscriber;
use App\Models\SmtpSetting;
use App\Models\SubscriptionList;  // <-- Add this line to import the model for subscription lists
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the total count of subscribers, newsletters, and subscription lists
        $totalSubscribers = Subscriber::count();
        $totalNewslettersSent = Newsletter::count();
        $totalSubscriptionLists = SubscriptionList::count();  // <-- Count subscription lists

        // Pass the counts to the dashboard view
        return view('dashboard', compact('totalSubscribers', 'totalNewslettersSent', 'totalSubscriptionLists'));
    }

    public function showSmtpSettings()
    {
        $settings = SmtpSetting::first();
        return view('dashboard.smtp-settings', compact('settings'));
    }

    public function updateSmtpSettings(Request $request)
    {
        $request->validate([
            'host' => 'required',
            'port' => 'required',
            'username' => 'required',
            'password' => 'required',
            'encryption' => 'required',
        ]);

        $settings = SmtpSetting::first() ?? new SmtpSetting();
        $settings->fill($request->only('host', 'port', 'username', 'password', 'encryption'));
        $settings->save();

        return redirect()->route('dashboard.smtp-settings')->with('success', 'SMTP settings updated.');
    }
}