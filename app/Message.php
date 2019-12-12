<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    const STATUS_PENDING = 'pending';
    const STATUS_QUEUED = 'queued';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_FAILED = 'failed';

    /**
     * Get the contact for the message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }

    /**
     * Get the campaign for the message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Campaign');
    }
}
