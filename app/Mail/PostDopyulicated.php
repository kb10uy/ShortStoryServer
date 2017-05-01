<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Post;

class PostDopyulicated extends Mailable
{
    use Queueable, SerializesModels;
    
    private $post = null;

    public function __construct(Post $target)
    {
        $this->post = $target;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('あなたの作品がシコられました - ' . config('app.name'))
            ->markdown('emails.post.dopyulicated', ['post' => $this->post]);
    }
}
