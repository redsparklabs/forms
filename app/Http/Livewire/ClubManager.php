<?php

namespace App\Http\Livewire;

use App\Actions\CreateClub;
use App\Actions\DestroyClub;
use App\Actions\UpdateClub;
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
        CreateClub::run(
            $this->user,
            $this->team,
            $this->createForm
        );

    }

    public function confirmUpdateAction()
    {
        $form = $this->team->clubs()->find($this->idBeingUpdated);

         $this->updateForm = [
            'name' => $form->name
        ];
    }

    public function updateAction()
    {
        $club  = $this->team->clubs()->find($this->idBeingUpdated);

        UpdateClub::run(
            $this->user,
            $this->team,
            $club,
            $this->updateForm
        );
    }

    public function destroyAction()
    {
        $club  = $this->team->clubs()->find($this->idBeingDestroyed);

        DestroyClub::run(
            $this->user,
            $this->team,
            $club
        );
    }

    public function render()
    {
        return view('livewire.club-manager');
    }
}
