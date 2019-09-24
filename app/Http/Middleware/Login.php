<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
class Login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!session('key1')){
             return redirect('/login');
        }else{
            $user =User::find(session('key2'));
            if(session('key1')!=$user -> token){
                return redirect('/login');
            }else{
                return $next($request);
            }
        }
        
    }
}
