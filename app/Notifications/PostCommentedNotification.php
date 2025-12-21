<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;

class PostCommentedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $post;
    protected $comment;
    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Post $post, Comment $comment, User $user)
    {
        $this->post = $post;
        $this->comment = $comment;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'comment',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_avatar' => $this->user->avatar_url,
            'post_id' => $this->post->id,
            'comment_id' => $this->comment->id,
            'message' => $this->user->name . ' mengomentari postingan Anda',
            'url' => route('posts.show', $this->post->id),
        ];
    }
}