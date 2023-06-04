<?php

namespace App\Enums;

Enum AppointmentStatesEnum: string
{
    case PENDING = "Pendiente";
    case CONFIRMED = "Confirmado";
    case ACOMPLISHED = "Completado";
    case REJECTED = "Rechazado";
    case CANCELLED = "Cancelado";
    case MISSING = "Perdido";

    public static function values(): array
    {
       return array_column(self::cases(), 'value');
    }
}