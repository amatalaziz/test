<?php

namespace App\Http\Livewire\Notifications;

use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;

class Indicator extends Component
{
    public function markAsRead($notificationId)
    {
        DatabaseNotification::find($notificationId)->markAsRead();
        $this->emit('refreshNotifications');
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->emit('refreshNotifications');
    }

    public function render()
    {
        return view('livewire.notifications.indicator');
    }
}