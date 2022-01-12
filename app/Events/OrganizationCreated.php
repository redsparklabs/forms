<?php

namespace App\Events;

use App\Models\Organization;

class OrganizationCreated extends OrganizationEvent
{
    public function __construct($organization)
    {
        $organization->questions()->createMany(config('questions.qualitative-intuitive-scoring-feedback'));
    }
}
