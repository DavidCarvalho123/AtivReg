<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Register extends Component
{
    public $form = [
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confimation' => '',
    ];

    public function submit()
    {
        $this->validate([
            'form.email' => 'required|email',
            'form.name' => 'required',
            'form.password' => 'required',
        ]);

        User::create($this->form);
        return redirect(route('Login'));
    }

    public function render()
    {
        return view('livewire.register');
    }
}
