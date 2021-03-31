<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class SetPasswordNotification extends Notification
{

    protected $email;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(config('app.url').route('user.password.set', [
            'email' => $this->email,
        ], false));     
        return (new MailMessage)
            ->subject(Lang::get('Set Password Notification'))
            ->line(Lang::get('Welcome to Goal Scaling Solutions - or welcome back! You are receiving this message because you have been added to the Goal Scaling Solutions application or because you have requested a password reset. Please click on the "set password" button below to set or reset a password for your account.'))
            ->action(Lang::get('Set Password'), $url)
            ->line(Lang::get('If you did not request a new password and did not expect to be receiving a new Goal Scaling Solutions account, please notify us immediately by emailing info@goalscaling.com or by calling 844-243-6269 extension 0. Please include your name, email address, and phone number. Thank you.
            '));
    }
}
