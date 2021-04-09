<?php

namespace App\Providers;

use App\Models\Colaboradore;
use App\Models\Familiare;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate para super admin
        Gate::define('sadmin-only', function (User $user)
        {
            if(DB::table('users')->where('id','=',Auth::user()->id)->where('db','=','')->exists())
            {
                return true;
            }
            else
            {
                return false;
            }
        });
        // Gate para admin
        Gate::define('admin-only', function (User $user)
        {
            if(Auth::user()->IsFamil == 0)
            {
                $colaboradores = Colaboradore::where('email', '=', Auth::user()->email)->first();

                if($colaboradores->unidades->count() < 1)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        });

        // Gate para multi unidades
        Gate::define('multiuni-only', function (User $user)
        {
            if(Auth::user()->IsFamil == 0)
            {
                $colaboradores = Colaboradore::where('email', '=', Auth::user()->email)->where('IsDeleted',0)->first();

                if($colaboradores->unidades->count() <= 1 )
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }
            else
            {
                $a = Familiare::where('nome_utilizador',Auth::user()->email)->first();
                $c = '';
                foreach($a->clientes as $b)
                {
                    if($b->unidades_id == $c)
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                    $c = $b->unidades_id;
                }
            }
        });

    }
}
