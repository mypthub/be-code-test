<?php

namespace App\Notifications;

use App\Organisation;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrganisationCreatedNotification extends Notification
{
    /**
     * @var Organisation
     */
    private $organisation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Organisation $organisation)
    {
        $this->organisation = $organisation;
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
        return (new MailMessage)
            ->line("Hello {$this->organisation->owner->name}")
            ->line("{$this->organisation->name} was created!")
            ->line('Thank you for using our application!');
    }
}
