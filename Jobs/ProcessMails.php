<?php

namespace WebReinvent\VaahCms\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use WebReinvent\VaahCms\Models\User;



class ProcessMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $mail;
    public $to;
    public $from_email;
    public $from_name;
    public $cc;
    public $bcc;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mail, $to, $cc=null, $bcc=null)
    {
        $this->mail = $mail;
        $this->to = $to;
        $this->cc = $cc;
        $this->bcc = $bcc;

    }

    //----------------------------------------------------------



    //----------------------------------------------------------

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::to($this->to)
            ->cc($this->cc)
            ->bcc($this->bcc)
            ->send($this->mail);
    }
}
