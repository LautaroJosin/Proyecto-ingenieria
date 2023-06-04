<?php

namespace App\Enums;

Enum AppointmentStatesEnum: string
{
    case PENDING = "Pending";
    case CONFIRMED = "Confirmed";
    case ACOMPLISHED = "Acomplished";
    case REJECTED = "Rejected";
    case CANCELLED = "Cancelled";
    case MISSING = "Missing";

    public static function values(): array
    {
       return array_column(self::cases(), 'value');
    }
}