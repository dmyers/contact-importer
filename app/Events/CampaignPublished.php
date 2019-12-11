<?php

namespace App\Events;

use App\Campaign;
use Illuminate\Queue\SerializesModels;

class CampaignPublished
{
    use SerializesModels;

    /**
     * The campaign instance that was published.
     *
     * @var \App\Campaign
     */
    public $campaign;

    /**
     * Create a new event instance.
     *
     * @param  \App\Campaign  $campaign
     * @return void
     */
    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }
}
