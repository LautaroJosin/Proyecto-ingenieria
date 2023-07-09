<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class AdoptionDogStatistics
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        return $this->chart->pieChart()
            ->setTitle('Cantidad de perros en adopción publicados')
            ->addData([40, 50, 30])
            ->setLabels(['Player 7', 'Player 10', 'Player 9']);
    }
}
