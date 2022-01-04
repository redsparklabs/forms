<?php

namespace App\Actions\Jetstream;


class DeleteOrganization
{
    /**
     * Delete the given organization.
     *
     * @param  mixed  $organization
     * @return void
     */
    public function delete($organization)
    {
        $organization->purge();
    }
}
