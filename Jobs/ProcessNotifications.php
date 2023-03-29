<?php

namespace WebReinvent\VaahCms\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;
use WebReinvent\VaahCms\Models\Notification;
use WebReinvent\VaahCms\Models\User;

class ProcessNotifications implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $notification;
    public $user;
    public $inputs;
    public $priority;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Notification $notification, User $user, $inputs=[], $priority='default')
    {
        $this->notification = $notification;
        $this->user = $user;
        $this->inputs = $inputs;
        $this->priority = $priority;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $inputs = $this->inputs;
        $inputs['user_id'] = $this->user->id;
        $inputs['notification_id'] = $this->notification->id;
        //$request = new Request($inputs);
        Notification::send($this->notification, $this->user, $this->inputs);
    }


    public function failed(Throwable $exception)
    {
        // Send user notification of failure, etc...
    }

}
