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
        return view('donationCampaign.paymentForm')->with('campaign_id',$campaign_id);
    }




    /* Procesa y valida una donacion :

       - Se valida que la tarjeta no sea la tarjeta que genera el fallo con el servidor

       - Se valida que la tarjeta existe

       - Se validan los datos de la tarjeta

       - Se valida que la tarjeta pueda realizar la donacion

       - Finalmente se efectua la donacion y se actualiza el monto recaudado de la campaña

    */ 
    public function processDonation ($campaign_id , Request $request)
    {
        // Se realiza la conexion con el servidor

        if($request->input('card_number') == Card::where('card_number' , 9999888877776666)->first()->card_number)
            return redirect()->route('donation-campaign.index')
                ->with('error server conection' , 'Error al conectar con el servidor');
        else {

            /* Esta parte se deberia hacer usando validate... o creando reglas de validacion especificas para este tipo de request */

            if(Card:where('card_number', request->input('card_number'))->exists()) 
                $card_found = Card:where('card_number', request->input('card_number'))->get();

            if($card_found->cardholder == $request->input('cardholder')

                if($card_found->card_type == $request->input('card_type')

                    if($card_found->cvv == $request->input('cvv')

                        if($card_found->expiration_date == $request->input('expiration_date')
                        {
                            if($card_found->balance >= $request->input('amount')) {

                                $card_found->balance -= $request->input('amount'));
                                $campaign = DonationCampaign::where('id' , $campaign_id)->first()->get();
                                $campaign->current_fundraised += $request->input('amount');
                                $campaign->save();

                                return redirect()->route('donation-campaign.index')
                                ->with('donation completed' , 'Se realizo la donacion con exito!');

                            }   
                        }

        }

    }
}
