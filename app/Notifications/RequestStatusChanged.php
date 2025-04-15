<?php

namespace App\Notifications;

use App\Models\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Enums\RequestStatus;

class RequestStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Request $request, public string $oldStatus)
    {
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Request Status Updated')
            ->line('The status of your request has been changed.')
            ->line('Request Title: ' . $this->request->title)
            ->line('Old Status: ' . RequestStatus::from($this->oldStatus)->label())
            ->line('New Status: ' . RequestStatus::from($this->request->status)->label())
            ->action('View Request', route('requests.show', $this->request))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'request_id' => $this->request->id,
            'request_title' => $this->request->title,
            'old_status' => $this->oldStatus,
            'new_status' => $this->request->status,
            'message' => 'Request status changed from ' . 
                RequestStatus::from($this->oldStatus)->label() . ' to ' . 
                RequestStatus::from($this->request->status)->label(),
            'url' => route('requests.show', $this->request),
        ];
    }
}