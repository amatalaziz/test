<?php

namespace App\Http\Livewire\Notifications;

use Livewire\Component;

class Indicator extends Component
{
    public function render()
    {
        return view('livewire.notifications.indicator');
    }



    public function toMail($notifiable)
{
    $url = route('requests.show', $this->request->id);
    
    return (new MailMessage)
        ->subject('Approval Required: ' . $this->request->title)
        ->line('A request requires your approval.')
        ->action('Review Request', $url)
        ->line('Thank you for using our application!');
}
}



