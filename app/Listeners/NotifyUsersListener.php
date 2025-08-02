<?php

namespace App\Listeners;

use App\Events\NewPostPublished;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\NewPostNotification;
use Illuminate\Support\Facades\Notification;

class NotifyUsersListener implements ShouldQueue
{
    public function handle(NewPostPublished $event)
    {
        $post = $event->post;
        $users = User::all();

        foreach ($users as $user) {
            $user->notify(new NewPostNotification($post));
        }
    }
}
