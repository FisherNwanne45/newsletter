<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'status', // e.g., draft, sent
        'subscription_list_id', // Target subscription list
    ];

    /**
     * Define the relationship to the SubscriptionList model.
     */
    public function subscriptionList()
    {
        return $this->belongsTo(SubscriptionList::class);
    }
}