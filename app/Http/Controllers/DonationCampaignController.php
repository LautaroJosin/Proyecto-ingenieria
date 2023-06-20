<?php

namespace App\Http\Controllers;

use App\Models\DonationCampaign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Card;

class DonationCampaignController extends Controller
{
    public function index() {
        return view('donationCampaign.index')->with('campaigns', DonationCampaign::all());
    }

    public function create() {
        return view('donationCampaign.create');
    }

    public function edit(DonationCampaign $campaign) {
        return view('donationCampaign.edit')->with('campaign', $campaign);
    }

    public function update(DonationCampaign $campaign, Request $request) {
        $this->setCampaign($campaign, $request)->save();
        return redirect()->route('donation-campaign.index');
    }

    public function store(Request $request)
    {
        $this->setCampaign(new DonationCampaign, $request)->save();
        return redirect()->route('donation-campaign.index')->with('success campaign register', 'La publicación ha sido exitosa');
    }

    private function setCampaign(DonationCampaign $campaign, Request $request): DonationCampaign
    {
        $campaign->name = $request->input('name');
        $campaign->start_date = Carbon::now()->toDateString();
        $campaign->end_date = $request->input('end_date');
        $campaign->description = $request->input('description');
        $campaign->fundraising_goal = $request->input('fundraising_goal');
        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'required|image',
            ], 
            [
                'photo.image' => 'La foto debe ser una imagen',
            ]);
            $url = $request->file('photo')->store('public/donationCampaigns'); 
            $campaign->photo = Storage::url($url);
        }
        return $campaign;
    }


    /* Redirije a la vista del formulario para donar a una campaña */
    public function donate ($campaign_id)
    {
        return view('donationCampaign.paymentForm')->with($campaign_id);
    }

    /* Procesa y valida una donacion */ 
    
    public function processDonation (Request $request)
    {
        // Se realiza la conexion con el servidor

        if($request->input('card_number') == Card::where('card_number' , 9999888877776666)->first())
            dd('Tarjeta no valida');
        else dd('tarjeta valida');

        // Se valida que la tarjeta existe, y si es asi, se continua validando los datos

        //Por ultimo se valida si la tarjeta tiene el saldo para realizar la donacion
    }
}
