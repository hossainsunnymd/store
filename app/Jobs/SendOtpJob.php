<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendOtpJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $receipent;
    public $mailable;
    public function __construct($receipent,$mailable)
    {
        $this->receipent=$receipent;
        $this->mailable=$mailable;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->receipent)->send($this->mailable);
    }
}
