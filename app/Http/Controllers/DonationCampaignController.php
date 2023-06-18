<?php

namespace App\Http\Controllers;

use App\Models\DonationCampaign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DonationCampaignController extends Controller
{
    public function index() {
        return view('donationCampaign.index')->with('campaigns', DonationCampaign::all());
    }

    public function create() {
        return view('donationCampaign.create');
    }

    public function store(Request $request)
    {
        $this->setCampaign(new DonationCampaign, $request)->save();
        return redirect()->route('donation-campaign.index')->with('success campaign register', 'La publicación ha sido exitosa');
    }

    private function setCampaign(DonationCampaign $campaign, Request $request): DonationCampaign
    {
        $request->validate([
            'photo' => 'required|image',
        ], 
        [
            'photo.image' => 'Publicación fallida, la foto es inválida',
        ]);

        $campaign->name = $request->input('name');
        $campaign->start_date = Carbon::now()->toDateString();
        $campaign->end_date = $request->input('end_date');
        $campaign->description = $request->input('description');
        $campaign->fundraising_goal = $request->input('fundraising_goal');
        $url = $request->file('photo')->store('public/donationCampaigns'); $campaign->photo = Storage::url($url);
        return $campaign;
    }
}
