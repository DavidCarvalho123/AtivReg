<?php

namespace App\Http\Livewire;

use App\Models\User;
use Brotzka\DotenvEditor\DotenvEditor;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Mudarpasse extends Component
{
    public $passwordantiga,$passwordnova, $error, $passwordnovaconfirm;

    public function mount()
    {
        $this->error = '';
    }

    public function submitpalavra()
    {
        $this->error = '';
        try
        {
            $this->validate([
                'passwordantiga' => 'required',
                'passwordnova' => 'required',
                'passwordnovaconfirm' => 'required',
            ]);
        }
        catch(Exception $e)
        {

            $this->error = 'Ainda faltam campos para preencher';
            return;
        }
        
        $hashedPassword = User::where('email',Auth::user()->email)->first();
        if($this->passwordnovaconfirm == '' or $this->passwordnova == '')
        {
            $this->error = 'Faltam campos para preencher';
        }
        else
        {
            if($this->passwordnova == $this->passwordnovaconfirm)
            {
                if (Hash::check($this->passwordantiga, $hashedPassword->password))
                {
                    $hashedPassword->update([
                        'password' => $this->passwordnova,
                    ]);
                    $env = new DotenvEditor();
                    $env->changeEnv([
                        'DB_DATABASE2' => '',
                    ]);
                    Auth::logout();
                    return redirect('/login');
                }
                else
                {
                    $this->error = 'Palavra-passe antiga não está certa';
                    return;
                }
            }
            else
            {
                $this->error = 'A confirmação da palavra-passe tem que ser igual à palavra-passe nova';
                return;
            }
        }

    }

    public function render()
    {
        return view('livewire.mudarpasse');
    }
}
