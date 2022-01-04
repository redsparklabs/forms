<?php

namespace App\Http\Livewire;

use App\Actions\CreateTeam;
use App\Actions\DestroyTeam;
use App\Actions\UpdateTeam;
use App\Http\Livewire\BaseComponent;
use App\Models\Team;


class ClubManager extends BaseComponent
{
    public $componentName = 'Team';

    public $createForm = [
        'name' => ''
    ];

    public $updateForm = [
        'name' => ''
    ];

    public function mount(Team $team)
    {
        $this->model = $team;
    }

    public function createAction()
    {
        CreateTeam::run(
            $this->user,
            $this->team,
            $this->createForm
        );

    }

    public function confirmUpdateAction()
    {
        $form = $this->team->teams()->find($this->idBeingUpdated);

         $this->updateForm = [
            'name' => $form->name
        ];
    }

    public function updateAction()
    {
        $team  = $this->team->teams()->find($this->idBeingUpdated);

        UpdateTeam::run(
            $this->user,
            $this->team,
            $team,
            $this->updateForm
        );
    }

    public function destroyAction()
    {
        $team  = $this->team->teams()->find($this->idBeingDestroyed);

        DestroyTeam::run(
            $this->user,
            $this->team,
            $team
        );
    }

    public function render()
    {
        return view('livewire.team-manager');
    }
}
