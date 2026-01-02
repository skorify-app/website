<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SubtestChangedNotification extends Notification
{
    use Queueable;

    public $actor;
    public $actorId;
    public $action;
    public $subtestName;

    public function __construct(string $actor, ?string $actorId, string $action, string $subtestName)
    {
        $this->actor = $actor;
        $this->actorId = $actorId;
        $this->action = $action; // 'menambahkan'|'menghapus'|'mengedit'
        $this->subtestName = $subtestName;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'actor' => $this->actor,
            'actor_id' => $this->actorId,
            'action' => $this->action,
            'subtest' => $this->subtestName,
        ];
    }
}
