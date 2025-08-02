<?php

namespace App\Observers;

use App\Models\Post;
use App\Events\NewPostPublished;

class PostObserver
{
    public function updated(Post $post)
    {
        if ($post->isDirty('status') &&
            $post->getOriginal('status') === 'draft' &&
            $post->status === 'published') {
            
            event(new NewPostPublished($post));
        }
    }
}
