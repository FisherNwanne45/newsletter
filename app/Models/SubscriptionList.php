<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionList extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Define the relationship where a subscription list has many subscribers.
     */
    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }
}