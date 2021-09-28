<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetRequest extends Notification
{
    use Queueable;

    protected $token, $email, $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token,$email, $user)
    {
        $this->token = $token;
        $this->email = $email;
        $this->user = $user;
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
        $url = config('app.front_url') . '?reset-password=' . $this->token . '&email=' . $this->email ;
        return (new MailMessage)
            ->greeting('Здравствуйте, '. $this->user->name)
            ->subject('Восстановление пароля')
            ->line('Перейдите по ссылке ниже для восстановления пароля')
            ->action('восстановление пароля',$url)
            ->line('Если эта ссылка не работает, откройте новое окно браузера, а затем скопируйте и вставьте URL-адрес в адресную строку.');
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
