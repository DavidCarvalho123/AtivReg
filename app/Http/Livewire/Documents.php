<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Documents extends Component
{
    public $mostra = 0;

    public function mount()
    {
        $this->mostra = 0;
    }

    public function click1()
    {
        $this->mostra = 1;
    }

    public function click2()
    {
        $this->mostra = 2;
    }

    public function click3()
    {
        $this->mostra = 3;
    }

    public function render()
    {
        return view('livewire.documents');
    }
}
