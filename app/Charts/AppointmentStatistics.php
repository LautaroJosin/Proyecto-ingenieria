<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Appointment;

class AppointmentStatistics
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        return $this->chart->pieChart()
            ->setTitle('Estadisticas de turnos')
            ->addData([
                \App\Models\Appointment::where('state', 'Confirmado')->count(),
                \App\Models\Appointment::where('state', 'Completado')->count(),
                \App\Models\Appointment::where('state', 'Perdido')->count(),
                \App\Models\Appointment::where('state', 'Cancelado')->count(),
                \App\Models\Appointment::where('state', 'Pendiente')->count(),
                \App\Models\Appointment::where('state', 'Rechazado')->count(),
            ])
            ->setLabels(['Cantidad de turnos confirmados',
                         'Cantidad de turnos completados', 
                         'Cantidad de turnos inasistidos',
                         'Cantidad de turnos cancelados',
                         'Cantidad de turnos pendientes',
                         'Cantidad de turnos rechazados',
            ])
            ->setFontColor('#ffffff');
    }
}
