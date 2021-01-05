<?php

namespace WebReinvent\VaahCms\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use WebReinvent\VaahCms\Entities\User;



class ProcessMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $to;
    public $mail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mail, $to)
    {
        $this->mail = $mail;
        $this->to = $to;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::to($this->to)->send($this->mail);
    }
}
