<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use App\Models\Website;
use App\Notifications\PostPublishNotification;
use App\Notifications\TestNotification;
use App\Services\NotificationServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_subscribed_users_will_get_notified_when_a_post_gets_published_on_a_website()
    {
        Notification::fake();
        // arrange
        $userOne = User::factory()->create();
        $userTwo = User::factory()->create();
        $userThree = User::factory()->create();

        $website = Website::factory()->create();

        $website->subscribes()->save($userOne);
        $website->subscribes()->save($userTwo);

        $post = Post::factory()->for($website)->create();

        // action
      
        $post->publish();

         // asert

        $this->assertNotificationSent($userOne);
        $this->assertNotificationSent($userTwo);
        $this->assertNotificationNotSent($userThree);

        // action
      
        $post->publish();

        // asert

        // $this->assertNotificationNotSent($userOne);
        // $this->assertNotificationNotSent($userTwo);
        $this->assertNotificationNotSent($userThree);
    }


    public function assertNotificationSent($user){
        Notification::assertSentTo(
            $user,
            function (PostPublishNotification $notification, $channels) use ($user) {

                $subscribes = $notification->website->subscribes;

                $idValue = 0;
            
                foreach ($subscribes as $key => $value) {
                    if($value->id === $user->id){
                        $idValue = $value->id;
                    }
                }
                
                return $idValue === $user->id ? true : false;
            
            }
        );
    }


    public function assertNotificationNotSent($user){
        Notification::assertNotSentTo(
            $user,
            function (PostPublishNotification $notification, $channels) use ($user) {

                $subscribes = $notification->website->subscribes;

                $idValue = 0;
            
                foreach ($subscribes as $key => $value) {
                    if($value->id === $user->id){
                        $idValue = $value->id;
                    }
                }
                
                return $idValue === $user->id ? true : false;
            
            }
        );
    }
    

    
}
