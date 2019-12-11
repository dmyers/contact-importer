<?php

namespace App;

use App\Events\CampaignPublished;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Publish the campaign and send messages to contacts.
     *
     * @return bool
     */
    public function publish()
    {
        $this->update([
            'published_at' => $this->freshTimestamp(),
        ]);

        event(new CampaignPublished($this));

        return true;
    }

    // protected $dispatchesEvents = [
    //     'saved' => \App\Events\AppSaved::class,
    // ];
}
