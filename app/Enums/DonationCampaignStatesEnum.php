<?php

namespace App\Enums;

Enum DonationCampaignStatesEnum: string
{
    case ACTIVE = "Vigente";
    case FINISHED = "Finalizada";

    public static function values(): array
    {
       return array_column(self::cases(), 'value');
    }
}