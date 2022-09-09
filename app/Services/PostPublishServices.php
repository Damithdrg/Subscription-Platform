<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Website;
use App\Notifications\PostPublishNotification;

class PostPublishServices {

    public function scan($post, $website, $subcribe_users){
       
        $publish_post = Post::where('id', $post->id)->first();
        Post::where('id', $post->id)->update(['notification_flag' => 1]);
       
        if($publish_post->notification_flag === 0){
            foreach ($subcribe_users as $subcribe_user) {
                $this->sendNotification($subcribe_user, $publish_post);
            }
        }
    }

    public function sendNotification($subcribe_user, $publish_post)
    {
        return $subcribe_user->notify(new PostPublishNotification($publish_post));
      
    }

}