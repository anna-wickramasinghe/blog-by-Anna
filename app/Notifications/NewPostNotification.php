<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;

class NewPostNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = config('app.url') . '/api/posts/' . $this->post->id . '/publish';

        return (new MailMessage)
                    ->subject('New Blog Post: ' . $this->post->title)
                    ->line('A new post has been published!')
                    ->action('Read Now', $url)
                    ->line('Thank you for using our application!');
    }
}
