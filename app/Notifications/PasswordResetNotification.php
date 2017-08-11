<?php

namespace App\Notifications;

use App\Model\Admin;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordResetNotification extends Notification {
  /**
   * The password reset token.
   *
   * @var string
   */
  public $token;

  /**
   * Create a notification instance.
   *
   * @param  string $token
   * @return void
   */
  public function __construct($token) {
    $this->token = $token;
  }

  /**
   * Get the notification's channels.
   *
   * @param  mixed $notifiable
   * @return array|string
   */
  public function via($notifiable) {
    return ['mail'];
  }

  /**
   * Build the mail representation of the notification.
   *
   * @param  mixed $notifiable
   * @return \Illuminate\Notifications\Messages\MailMessage
   */
  public function toMail($notifiable) {
    return (new MailMessage)
      ->subject("Сброс пароля")
      ->markdown('notifications.email')
      ->line('Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.')
      ->action('Сбросить Пароль', $this->getActionUrl($notifiable))
      ->line('Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.');
  }

  protected function getActionUrl($notifiable) {
    if ($notifiable instanceof Admin) {
      return route('admin.password.reset', [
        'token' => $this->token,
        'email' => $notifiable->email,
      ]);
    }

    return route('password.reset', [
      'token' => $this->token,
      'email' => $notifiable->email,
    ]);
  }
}
