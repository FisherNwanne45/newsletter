<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\SubscriptionList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriberController extends Controller
{
    // Display all subscription lists with subscriber counts
    public function index()
    {
        // Fetch all subscription lists with the count of associated subscribers
        $subscriptionLists = SubscriptionList::withCount('subscribers')->get();
        return view('subscribers.index', compact('subscriptionLists'));
    }

    // Show subscribers of a specific list on a separate page
    public function showList($listId)
    {
        $list = SubscriptionList::findOrFail($listId);
        $subscribers = $list->subscribers;

        return view('subscribers.list', compact('subscribers', 'list'));
    }

    // Show form for importing subscribers
    public function showImportForm()
    {
        $subscriptionLists = SubscriptionList::all();
        return view('subscribers.import', compact('subscriptionLists'));
    }

    // Handle subscriber import (CSV or TXT)
     public function import(Request $request)
{
    $request->validate([
        'subscriber_file' => 'required|file|mimes:csv,txt|max:2048',
        'list_id' => 'nullable|exists:subscription_lists,id',
        'new_list_name' => 'nullable|string|max:255|unique:subscription_lists,name',
    ]);

    DB::beginTransaction();

    try {
        // Determine list to add subscribers to
        $listId = $request->filled('new_list_name') 
            ? SubscriptionList::create(['name' => $request->new_list_name])->id
            : $request->list_id;

        // Read the uploaded file
        $file = $request->file('subscriber_file');
        $data = array_map('str_getcsv', file($file->getRealPath()));

        $successCount = 0;
        $failedEmails = []; // To store emails that couldn't be added
        $skippedCount = 0;

        foreach ($data as $row) {
            // Extract email and assign a default name if missing
            $email = isset($row[1]) ? $row[1] : $row[0];
            $name = isset($row[1]) ? $row[0] : 'Client'; // Use 'Client' if name is not provided

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $failedEmails[] = $email; // Invalid email
                $skippedCount++;
                continue;
            }

            // Check for duplicate email
            if (Subscriber::where('email', $email)->exists()) {
                $failedEmails[] = $email; // Duplicate email
                $skippedCount++;
                continue;
            }

            // Create the subscriber
            Subscriber::create([
                'name' => $name, // Use default or provided name
                'email' => $email,
                'status' => 'active',
                'subscription_list_id' => $listId,
            ]);

            $successCount++;
        }

        DB::commit();

        // Prepare feedback message
        $message = "{$successCount} subscribers imported successfully.";
        if (count($failedEmails) > 0) {
            $message .= " The following emails were skipped because they already exist or were invalid: " . implode(', ', $failedEmails);
        }

        return redirect()->route('subscribers.index')->with('success', $message);
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('subscribers.index')->withErrors(['error' => 'Import failed: ' . $e->getMessage()]);
    }
}



    // Show form for editing a subscription list's name
    public function editListName($listId)
    {
        $list = SubscriptionList::findOrFail($listId);
        return view('subscribers.edit', compact('list'));
    }

    // Update the name of a subscription list
    public function updateList(Request $request, $listId)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subscription_lists,name,' . $listId,
        ]);

        $list = SubscriptionList::findOrFail($listId);
        $list->update(['name' => $request->name]);

        return redirect()->route('subscribers.index')->with('success', 'Subscription list name updated successfully.');
    }

    // Show form for creating a new subscription list
    public function createList()
    {
        return view('subscribers.createList');
    }

    // Store a new subscription list
    public function storeList(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subscription_lists,name',
        ]);

        SubscriptionList::create(['name' => $request->name]);

        return redirect()->route('subscribers.index')->with('success', 'Subscription list created successfully.');
    }

    // Delete a subscriber
    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return redirect()->route('subscribers.index')->with('success', 'Subscriber deleted successfully.');
    }

    // Delete a subscription list if empty
    public function destroyList($id)
{
    // Find the subscription list
    $list = SubscriptionList::findOrFail($id);

    // Delete all the subscribers associated with this list
    $list->subscribers()->delete();  // This will delete all subscribers related to this list

    // Now delete the subscription list itself
    $list->delete();

    return redirect()->route('subscribers.index')->with('success', 'Subscription list and all associated subscribers deleted successfully.');
}

}