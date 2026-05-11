<?php

namespace App\Notifications;

use App\Models\Application;
use App\Models\ScholarshipCall;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ApplicationStatusChanged extends Notification
{
    use Queueable;

    public function __construct(
        public Application $application,
        public ScholarshipCall $scholarshipCall,
        public string $previousStatus,
        public string $newStatus,
        public ?string $reason = null
    ) {}

    /**
     * Kanali preko kojih se šalje notifikacija
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    
    public function toDatabase($notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'scholarship_call_title' => $this->scholarshipCall->title,
            'previous_status' => $this->previousStatus,
            'new_status' => $this->newStatus,
            'reason' => $this->reason,
            'assigned_at' => now(),
        ];
    }

    
}