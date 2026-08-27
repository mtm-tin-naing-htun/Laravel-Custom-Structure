<?php

namespace App\Enums\Contracts;

interface HasLabel
{
    /**
     * Human readable label for the enum case (used in blade, resources, etc.).
     */
    public function label(): string;
}
