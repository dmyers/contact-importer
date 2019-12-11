<?php

namespace App\Listeners;

use App\Contact;
use App\Message;
use App\Events\CampaignPublished;
use App\Jobs\SendContactMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCampaignMessages implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CampaignPublished $event)
    {
        $campaign = $event->campaign;

        Contact::chunk(500, function ($contacts) use ($campaign) {
            $contacts->each(function ($contact) use ($campaign) {
                $message = Message::create([
                    'contact_id'  => $contact->id,
                    'campaign_id' => $campaign->id,
                    'body'        => $campaign->message,
                ]);

                SendContactMessage::dispatch($message);
            });
        });
    }
}
