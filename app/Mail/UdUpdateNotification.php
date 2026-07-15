<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UdUpdateNotification extends Mailable
{
    use Queueable, SerializesModels;

        public $ppcEmailData;
        public $attentionNamesString;
        public $emailHeader;
        public $inChargeList;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ppcEmailData, $attentionNamesString, $emailHeader, $inChargeList)
    {
        $this->ppcEmailData = $ppcEmailData;
        $this->attentionNamesString = $attentionNamesString;
        $this->emailHeader = $emailHeader;
        $this->inChargeList = $inChargeList;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
         return $this->subject('UD Monitoring System Notification')
                    ->view('emails.ud_notification');
    }
} 
