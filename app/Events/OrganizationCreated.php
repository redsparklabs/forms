<?php

namespace App\Events;

use App\Models\Organization;
use App\Actions\CreateForm;
class OrganizationCreated extends OrganizationEvent
{
    public function __construct($organization)
    {
        $organization->questions()->createMany(config('questions.qualitative-intuitive-scoring-feedback'));

        CreateForm::run(
            $organization->owner,
            $organization,
            [
                'name' => 'Standard Growth Board Form',
                'description' => 'Standard Growth Board Form',
            ]
        );

    }
}
