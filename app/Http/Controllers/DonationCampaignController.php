<?php

namespace App\Http\Controllers;

use App\Enums\DonationCampaignStatesEnum;
use App\Models\DonationCampaign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use Closure;

use App\Models\User;
use App\Models\Card;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

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
        $this->validation($request, $campaign);
        $campaign->name = $request->input('name');
        $campaign->start_date = Carbon::now()->toDateString();
        $campaign->end_date = $request->input('end_date');
        $campaign->description = $request->input('description');
        $campaign->fundraising_goal = $request->input('fundraising_goal');
        if ($request->hasFile('photo')) {
            $url = $request->file('photo')->store('public/donationCampaigns'); 
            $campaign->photo = Storage::url($url);
        }
        return $campaign;
    }

    private function validation(Request $request, DonationCampaign $campaign) {
        Validator::make($request->all(), [
            'photo' => 'sometimes|image',
            'name' => Rule::unique('donation_campaigns')
                ->where('state', DonationCampaignStatesEnum::ACTIVE->value)
                ->ignore($campaign->id, 'id'),
        ], 
        [
            'photo.image' => 'La foto debe ser una imagen',
            'name.unique' => 'Ya existe una campaña vigente con ese nombre',
        ])->stopOnFirstFailure()->validate();
    }

    /* Redirije a la vista del formulario para donar a una campaña */
    public function donate ($campaign_id)
    {
        return view('donationCampaign.paymentForm')->with('campaign_id',$campaign_id);
    }




    /* Procesa y valida una donacion */

    public function processDonation ($campaign_id , Request $request)
    {
        // Se realiza la conexion con el "servidor"

        if($request->input('card_number') == Card::where('card_number' , 9999888877776666)->first()->card_number)
            return redirect()->route('donation-campaign.index')
                ->with('error server conection' , 'Ocurrio un error al intentar conectar con el servidor, vuelva a intentar más tarde');

        else {

            // Se valida que la tarjeta existe y se validan el resto de datos

            $card_found = Card::where('card_number',$request->input('card_number'))->first();

            if($card_found == null) {
                return redirect()->back()
                    ->withErrors(['card_number' => 'La tarjeta ingresada no existe en el sistema'])
                    ->withInput();
            }

            else {

                $validator = Validator::make($request->all(), [

                    'card_type' => [
                        'bail',
                        'required',
                        function (string $attribute, mixed $value, Closure $fail) use ($card_found) {
                            if ($value != $card_found->card_type )
                                $fail("El tipo de tarjeta ingresado no coincide");
                            },
                    ],

                    'cardholder' => [
                        'bail',
                        'required',
                        function (string $attribute, mixed $value, Closure $fail) use ($card_found){
                            if ($value != $card_found->cardholder )
                                $fail("El titular de la tarjeta ingresada no coincide");
                            },
                    ],

                    'cvv' => [
                        'bail',
                        'required',
                        function (string $attribute, mixed $value, Closure $fail) use ($card_found){
                            if ($value != $card_found->cvv )
                                $fail("El cvv de la tarjeta ingresada no coincide");
                            },
                    ],
                    
                    /*
                    'expiration_date' => [
                        'bail',
                        'required',
                        function (string $attribute, mixed $value, Closure $fail) use ($card_found) {
                            if ($value != $card_found->expiration_date )
                                $fail("La fecha de expiracion de la tarjeta ingresado no coincide");
                            },
                    ],
                    */

                    'amount' => ['required','numeric'],

                ])->stopOnFirstFailure();

                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }
                else {

                    // Se valida que la tarjeta pueda realizar la donacion

                    // Finalmente se efectua la donacion y se actualiza el monto recaudado de la campaña


                    if($card_found->balance >= $request->input('amount') ) {

                        $card_found->balance -= $request->input('amount');

                        $card_found->save();

                        $campaign = DonationCampaign::where('id' , $campaign_id)->first();

                        $campaign->current_fundraised += $request->input('amount');

                        if ($campaign->current_fundraised >= $campaign->fundraising_goal) {
                            $campaign->state = DonationCampaignStatesEnum::FINISHED->value;
                            //Actualizar fecha de finalizacion
                        }

                        $campaign->save();

                        if(Auth::check()) {
                            $user = Auth::user();
                            $user->credits += ( 20 * $request->input('amount') ) / 100;
                            $user->save();
                        }

                        return redirect()->route('donation-campaign.index')
                        ->with('donation completed' , 'Se realizo la donacion con exito!');

                    } 
                    else {
                        return redirect()->back()
                        ->with('error card balance' , 'Su tarjeta no cuenta con el saldo suficiente para realizar la donación!');
                    }
                }

                  
            }
        }


    }

}

