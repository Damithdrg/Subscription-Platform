<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
    ];

    public function subscribes(){
        return $this->belongsToMany(User::class, 'user_website', 'website_id', 'user_id');
    }

    
}
