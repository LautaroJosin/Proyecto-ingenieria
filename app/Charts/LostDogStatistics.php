<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\LostDog;

class LostDogStatistics
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        return $this->chart->barChart()
            ->setTitle('Estadisticas del servicio de perdida y busqueda')

            ->addData('Perros',[
                       \App\Models\LostDog::where('found', 0)->count(),
                       \App\Models\LostDog::where('found', 1)->count(),
                       \App\Models\LostDog::where('reunited', 1)->count()
            ])

            ->setXAxis(['Cantidad de perros perdidos', 'Cantidad de perros encontrados', 'Cantidad de perros reunidos'])

            ->setFontColor('#ffffff');
    }
}
