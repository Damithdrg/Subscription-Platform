<?php

namespace App\Models;

use App\Services\PostPublishServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'website_id',
        'is_publish',
        'notification_flag',
    ];

    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }

    public function publish()
    {
        $this->is_publish = true;
        $this->save();
        
        $post_publish = new PostPublishServices();
        return $post_publish->scan($this, $this->website, $this->website->subscribes );
       
    }
}
