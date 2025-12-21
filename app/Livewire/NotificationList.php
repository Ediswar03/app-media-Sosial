<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationList extends Component
{
    public $notifications = [];

    public function mount()
    {
        $user = auth()->user();
        if ($user) {
            $this->notifications = $user->notifications()->latest()->take(20)->get();
        }
    }

    public function render()
    {
        return view('livewire.notification-list', [
            'notifications' => $this->notifications
        ]);
    }
}
