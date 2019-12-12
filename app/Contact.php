<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The fields for the contact that are stored
     * in the model in the format: Key => Label
     *
     * @var array
     */
    public const CORE_FIELDS = [
        'first_name'             => 'First Name',
        'last_name'              => 'Last Name',
        'email'                  => 'Email',
        'phone'                  => 'Phone',
        'sticky_phone_number_id' => 'Sticky Phone Number ID',
        'twitter_id'             => 'Twitter ID',
        'fb_messenger_id'        => 'Facebook Messenger ID',
        'time_zone'              => 'Time Zone',
        'unsubscribed_status'    => 'Unsubscribed Status',
    ];

    /**
     * Get the custom attributes for the contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customAttributes()
    {
        return $this->hasMany('App\CustomAttribute');
    }

    /**
     * Create custom attributes while ensuring the
     * contact only has a single value per key.
     *
     * @param  array  $attributes
     * @return void
     */
    public function createCustomAttributes(array $attributes): void
    {
        foreach ($attributes as $key => $value) {
            $this->customAttributes()->create(compact('key', 'value'));
        }
    }
}
