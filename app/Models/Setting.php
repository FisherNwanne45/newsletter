<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'value',
    ];

    // Optional: You can set 'name' to be a string in uppercase if required for consistency
    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }
}