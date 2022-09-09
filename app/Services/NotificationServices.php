<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Website;

class  NotificationServices
{
    private $notification_rules;
    public $send_notification = false;

    public function __construct($notification_rules)
    {
        $this->notification_rules = $notification_rules;
    }

    public function scan( array $post ){
        $website = Website::where('id', $post['website_id'])->first();
        // dd( $website);
        if ($website) {
            Post::create(
                [
                    'title' => $post['title'],
                    'description' => $post['description'],
                    'website_id' => $post['website_id']
                ]
            );

            $this->send_notification = $this->getNotificationState();
        }
    }

    public function getNotificationState() : bool
    {
        $notification_watting_users = Post::query()
                ->join('users_has_websites', 'posts.website_id', '=', 'users_has_websites.website_id')
                ->join('users', 'users_has_websites.user_id', '=', 'users.id')
                ->selectRaw('users.name, users.email, posts.title, posts.notification_flag')
                ->groupByRaw('posts.title, posts.notification_flag, users.name, users.email')->get();

        // dd( $notification_watting_users );
    }
}