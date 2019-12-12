<?php

namespace App\Jobs;

use Exception;
use App\Message;
use Twilio\Rest\Client as TwilioClient;
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
     * @param  \Twilio\Rest\Client  $twilio
     * @return void
     */
    public function handle(TwilioClient $twilio)
    {
        $message = $this->message;
        $contact = $message->contact;
        $campaign = $message->campaign;

        $message->update(['status' => Message::STATUS_QUEUED]);

        $to = $contact->phone;
        $from = $campaign->phone;
        $body = $message->body;

        try {
            $result = $twilio->messages->create($to, compact('from', 'body'));
        }
        catch (Exception $e) {
            report($e);
            $message->update([
                'status' => Message::STATUS_FAILED,
                'error'  => $e->getMessage(),
            ]);
            return;
        }

        $twilio_id = $result->sid;

        $message->update([
            'twilio_id' => $twilio_id,
            'status'    => Message::STATUS_DELIVERED,
        ]);
    }
}
