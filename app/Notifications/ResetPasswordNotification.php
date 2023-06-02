<?php

namespace App\Notifications;

use Illuminate\Support\Facades\Lang;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{

    public $token;

    public static $toMailCallback;


    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return (new MailMessage)
            ->greeting('Hola ' . $notifiable->name . ' ' . $notifiable->primerApellido)
            ->subject(Lang::getFromJson('Notificación para cambiar su contraseña'))
            ->line(Lang::getFromJson('Está recibiendo este correo, porque se recibio una petición para cambiar la contraseña desde su cuenta.'))
            ->action(Lang::getFromJson('Cambiar contraseña'), url(config('app.url').route('password.reset', $this->token, false)))
            ->line(Lang::getFromJson('Si no ha realizado esta petición, puede ignorar este correo.'))
            ->salutation('Saludos.');
    }


    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
