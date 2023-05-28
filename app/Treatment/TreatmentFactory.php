<?php

namespace App\Treatment;

use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use phpDocumentor\Reflection\Types\Boolean;
use function PHPUnit\Framework\throwException;

class TreatmentFactory
{
    public static function create($type): TreatmentStrategy
    {
        if (self::isVaccine($type)) {
            return new Vaccine();
        }
        elseif ($type == 'Desparasitación') {
            return new Deworming();
        }
        return new Others();
    }

    private static function isVaccine($type): bool
    {
    return $type == "Vacuna contra enfermedades" or $type == "Vacuna antirrábica";
    }
}
