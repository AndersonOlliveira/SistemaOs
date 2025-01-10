<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class VerificaNivel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$nivel)
    {
        if (auth()->check() && auth()->user()->nivel == $nivel) {

            dd($next($request));
            return $next($request);
        }

        // Se o usuário não tiver o nível necessário, redireciona ou retorna uma resposta de erro
        return redirect()->route('home')->with('error', 'Você não tem permissão para acessar esta página');
    }

}
