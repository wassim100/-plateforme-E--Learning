<?php

namespace App\Models;

// Use fully-qualified names to avoid IDE/analyzer resolution issues

class Category extends \Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
 
