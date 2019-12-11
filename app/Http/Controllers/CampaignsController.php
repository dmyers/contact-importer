<?php

namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{
    /**
     * Show a list of all the campaigns.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::query()
            ->latest()
            ->get();

        return response()->json($campaigns);
    }

    /**
     * Creates a new campaign.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required',
            'message' => 'required',
        ]);

        $campaign = Campaign::create($data);

        return response()->json($campaign);
    }

    /**
     * Publishes an existing campaign to
     * send messsages to contacts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function publish(Request $request, $campaign_id)
    {
        $campaign = Campaign::findOrFail($campaign_id);

        $published = $campaign->publish();

        return response()->json(compact('published', 'campaign'));
    }
}
