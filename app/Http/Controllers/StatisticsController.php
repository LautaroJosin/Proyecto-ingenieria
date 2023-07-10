<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\AdoptionDogStatistics;
use App\Charts\AppointmentStatistics;
use App\Charts\LostDogStatistics;

class StatisticsController extends Controller
{

    /* Redirije al menu principal de estadisticas*/
    public function index()
    {
        return view('statistics.index');   
    }

    /* Redirije a la vista con las estadisticas de perros en adopción */
    public function showStatisticsAdopDog(AdoptionDogStatistics $chart)
    {
        if( $this->thereIsNoValues($chart) )
            return view('statistics.indexAdoptionDog')
                ->with('msj','No hay estadisticas para mostrar');
        else
            return view('statistics.indexAdoptionDog', ['chart' => $chart->build()]); 
          
    }

    /* Redirije a la vista con las estadisticas de turnos */
    public function showStatisticsAppoint(AppointmentStatistics $chart)
    {
        if( $this->thereIsNoValues($chart) )
            return view('statistics.indexAppointment')
                ->with('msj','No hay estadisticas para mostrar');
        else 
            return view('statistics.indexAppointment', ['chart' => $chart->build()]);   
    }

    /* Redirije a la vista con las estadisticas de turnos */
    public function showStatisticsLostDog(LostDogStatistics $chart)
    {
        if( $this->thereIsNoValues($chart) )
            return view('statistics.indexLostDog')
                ->with('msj','No hay estadisticas para mostrar');
        else
            return view('statistics.indexLostDog', ['chart' => $chart->build()]);   
    }


    /* Evalua si el grafico esta cargado con datos de los servicios o si no tiene nada que mostrar 
       Retorna true si esta vacio , retorna false en caso contrario
    */
    private function thereIsNoValues ( $chart ) {

        /*  Funcionamiento de arrray filter :

            Recorre cada valor de array, pasándolos a la función callback. 
            Si la función callback devuelve true el valor actual desde array es 
            devuelto al array resultante

            Si no se proporciona callback, todas las entradas de array iguales a 
            false serán eliminadas. 

            Cuando se realizan conversiones a boolean, los siguientes valores se consideran false: 
             - El integer 0 y -0 (cero) 

        
            Por ende, si una posicion de dataset tiene el valor 0, se considerará falso y array_filter no devolvera dicho valor 
            Por lo tanto, si todas las posiciones tienen 0, el resultado sera un array vacio, con lo que la funcion
            empty devolvera true (esta todo vacio)
        */

        $res = $chart->build()->toVue(); //Convierto el grafico en un array (con su info)
        $tmp = array_filter($res['series']); //$res['series'] es un array con los valores del grafico
        if (empty($tmp)) {
            return true;
        }
        return false;

    }
}
