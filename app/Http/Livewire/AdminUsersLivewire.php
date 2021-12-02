<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\User;

class AdminUsersLivewire extends Component
{
    public function render()
    {
        $data = User::paginate(10);
        return view("livewire.admin-users-livewire", [
            "data" => $data,
        ]);
    }
}
