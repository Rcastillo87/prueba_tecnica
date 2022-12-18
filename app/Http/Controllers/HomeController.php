<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Tareas;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $noti = Tareas::where('id_user_asignado', Auth::user()->id)
        ->where('tipo', 'Pendiente')->count();
        return view('home')->with('noti',  $noti );
    }

    public function usuarios_lista()
    {
        $noti = Tareas::where('id_user_asignado', Auth::user()->id)
        ->where('tipo', 'Pendiente')->count();

        $list = User::offset(0)->limit(10)->get();
        
        return view('usuarios_lista')->with('list',  $list )->with('noti',  $noti );
    }

}
