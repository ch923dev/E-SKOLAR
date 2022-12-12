<?php

namespace App\Notifications;

use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class UserWelcomeEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $user = $notifiable;
        // return (new MailMessage)->view('vendor.notifications.text');
        return (new MailMessage)
            ->greeting('Hello ' . Str::before($user->name, ' ') . ',')
            ->line('The administrator has created an account for you. This email includes your account details. Login to your account using the credentials below, so please keep it safe.')
            ->line('Email: ' . $user->email)
            ->line('Password: ' . Str::slug(Str::before($user->email, '@') . ' ' . Role::find($user->role_id)->role))
            ->action('Login using this link', url('/admin/login'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
