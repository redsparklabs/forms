<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\DB;
use App\Actions\Jetstream\DeleteOrganization;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{

    /**
     * Create a new action instance.
     *
     * @param  \App\Actions\Jetstream\DeleteOrganization  $deletesOrganizations
     * @return void
     */
    public function __construct(public DeleteOrganization $deletesOrganizations)
    {
        $this->deletesOrganizations = $deletesOrganizations;
    }

    /**
     * Delete the given user.
     *
     * @param  mixed  $user
     * @return void
     */
    public function delete($user)
    {
        DB::transaction(function () use ($user) {
            $this->deleteOrganizations($user);
            $user->deleteProfilePhoto();
            $user->tokens->each->delete();
            $user->delete();
        });
    }

    /**
     * Delete the teams and team associations attached to the user.
     *
     * @param  mixed  $user
     * @return void
     */
    protected function deleteOrganizations($user)
    {
        $user->organizations()->detach();

        $user->ownedOrganizations->each(function ($organization) {
            $this->deletesOrganizations->delete($organization);
        });
    }
}
