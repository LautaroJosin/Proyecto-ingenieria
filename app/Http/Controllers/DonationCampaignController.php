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
use App\Models\DonationRecord;  
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

    public function finish(DonationCampaign $campaign) {
        $campaign->state = DonationCampaignStatesEnum::FINISHED->value;
        $campaign->end_date = Carbon::now()->toDateString();
        $campaign->save();
        return redirect()->route('donation-campaign.index');
    }

    public function filter(Request $request)
    {
        $query = DonationCampaign::query();

        if ($request->filled('name')) $query->where('name', 'LIKE', '%' . $request->input('name') . '%');
        if ($request->filled('description')) $query->where('description', 'LIKE', '%' . $request->input('description') . '%');
        if ($request->filled('id')) $query->where('id', '=', $request->input('id'));
        if ($request->filled('state')) $query->where('state', $request->input('state'));
        if ($request->filled('date')) {
            $query->whereDate('start_date', '<=', $request->input('date'))
                ->whereDate('end_date', '>=', $request->input('date'));
        }
        return view('donationCampaign.index')->with('campaigns', $query->get());
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

    public function records (DonationCampaign $campaign) {
        return view('donationCampaign.record')->with('campaign', $campaign);
    }



    /* Procesa y valida una donacion */

    public function processDonation ($campaign_id , Request $request)
    {
        // Se realiza la conexion con el "servidor"

        if($request->input('card_number') == Card::where('card_number' , 9999888877776666)->first()->card_number)
            return redirect()->route('donation-campaign.index')
                ->with('error server conection' , 'Falló la conexión con el sistema de pagos, inténtelo nuevamente más tarde');

        else {

            // Se valida que la tarjeta existe y se validan el resto de datos

            $card_found = Card::where('card_number',$request->input('card_number'))->first();

            if($card_found == null) {
                return redirect()->back()
                    ->withErrors(['card_number' => 'La tarjeta ingresada es invalida'])
                    ->withInput();
            }

            else {

                $validator = Validator::make($request->all(), [

                    'card_type' => [
                        'bail',
                        'required',
                        function (string $attribute, mixed $value, Closure $fail) use ($card_found) {
                            if ($value != $card_found->card_type )
                                $fail("La tarjeta ingresada es invalida");
                            },
                    ],

                    'cardholder' => [
                        'bail',
                        'required',
                        function (string $attribute, mixed $value, Closure $fail) use ($card_found){
                            if ($value != $card_found->cardholder )
                                $fail("La tarjeta ingresada es invalida");
                            },
                    ],

                    'cvv' => [
                        'bail',
                        'required',
                        function (string $attribute, mixed $value, Closure $fail) use ($card_found){
                            if ($value != $card_found->cvv )
                                $fail("La tarjeta ingresada es invalida");
                            },
                    ],
                    
                    
                    'expiration_date' => [
                        'bail',
                        'required',
                        function (string $attribute, mixed $value, Closure $fail) use ($card_found) {
                            if ($value != $card_found->expiration_date->format('Y-m-d') ){
                                $fail("La tarjeta ingresada es invalida");
                            }
                        }
                    ],
                    

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
                            $campaign->end_date = Carbon::now()->toDateString();
                        }

                        $campaign->save();

                        $donationRecord = new DonationRecord;

                        $donationRecord->campaign_id = $campaign->id;
                        $donationRecord->amount = $request->input('amount');


                        // Si el usuario esta logueado se le acredita el 20% de su donacion
                        if(Auth::check()) {
                            $user = Auth::user();
                            $credits = ( 20 * $request->input('amount') ) / 100;
                            $user->credits += $credits;
                            $user->save();

                            $donationRecord->user_id = $user->id;
                            $donationRecord->was_registered = true;

                            $donationRecord->save();


                            return redirect()->route('donation-campaign.index')
                            ->with('donation completed' , 'La donación se realizó exitosamente, se le otorgó el 20% del monto de su donación en créditos para utilizar en la veterinaria. Gracias por su aporte');
                        }
                        else {
                            
                            $donationRecord->was_registered = false;

                            $donationRecord->save();

                            return redirect()->route('donation-campaign.index')
                            ->with('donation completed' , 'La donación se realizó exitosamente. Gracias por su aporte'); 
                        }

                        

                    } 
                    else {
                        return redirect()->back()
                        ->with('error card balance' , 'Pago fallido, saldo insuficiente');
                    }
                }

                  
            }
        }


    }

}

