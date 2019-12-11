<?php

namespace App\Jobs;

use App\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendContactMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The message instance to send to the contact.
     *
     * @var \App\Message
     */
    protected $message;

    /**
     * Create a new job instance.
     *
     * @param  \App\Message  $message
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger('sending message to contacts!');

        $message = $this->message;

        $message->update([
            'status' => Message::STATUS_QUEUED,
        ]);
    }
}
