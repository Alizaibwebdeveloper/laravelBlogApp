<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;


class TopuserInfo extends Component
{
    protected $listners =[
        'updateTopUserInfo'=> '$refresh'
    ];
    public function render()
    {
        return view('livewire.admin.topuser-info',[
            'user'=> User::findOrFail(auth()->id())
        ]);
    }
}
