<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Notifications\StatusChangedNotification;
use Illuminate\Support\Facades\Notification;

class SendStatusChangeInMail implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user, public string $status, public string $title)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $notification = new StatusChangedNotification($this->status, $this->title);
        Notification::send($this->user, $notification);
    }
}
