<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

use App\Models\AdoptionDog;

class AdoptionDogStatistics
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        return $this->chart->donutChart()
            ->setTitle('Cantidad de perros en adopción publicados')
            ->addData([
                \App\Models\AdoptionDog::where('state', 'A')->count(),
                \App\Models\AdoptionDog::where('state', 'S')->count(),
            ])
            ->setLabels(['Cantidad de perros adoptados','Cantidad de perros sin adoptar'])
            ->setFontColor('#ffffff');
    }
}
