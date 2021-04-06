<?php
namespace App\Http\Livewire;



use App\Models\User;
use Brotzka\DotenvEditor\DotenvEditor;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Register extends Component
{
    public $form = [
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confimation' => '',
    ];
    public $Ncontribuinte, $erroNr, $db;

    public function submit()
    {

        $this->validate([
            'Ncontribuinte' => 'required|size:9',
            'db' => 'required|min:3',
            'form.email' => 'required|email',
            'form.name' => 'required',
            'form.password' => 'required',
        ]);

        $jsonurl = "https://www.nif.pt/?json=1&q=".$this->Ncontribuinte."&key=0a9574f1149b013bf93e044951b562e5";
        $json = file_get_contents($jsonurl);
        $contribuintearray = json_decode($json, true);


        if($contribuintearray['result'] == 'error')
        {
            $this->erroNr = 'Ocorreu um erro no registo, espere alguns minutos e tente outra vez';
        }
        else
        {
            $this->erroNr = '';
            if($contribuintearray['nif_validation'] == 'true')
            {
                $this->erroNr = '';
                    $bd = str_replace(' ','_',$this->db);
                    $bd = strtolower($bd);
                    User::create([
                        'db' => $bd,
                        'name' => $this->form['name'],
                        'email' => $this->form['email'],
                        'password' => $this->form['password'],
                    ]);

                    $env = new DotenvEditor();
                    $env->changeEnv([
                        'DB_DATABASE2' => $bd,
                    ]);

                    return redirect('/login');


                //apenas muda de view aqui dentro

            }
        else
        {
            $this->erroNr = 'Número de contribuinte inválido';
        }
     }



    }

    public function render()
    {
        return view('livewire.register');
    }
}
