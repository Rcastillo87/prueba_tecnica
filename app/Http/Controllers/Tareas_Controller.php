<?php

namespace App\Http\Controllers;
use App\Models\Tareas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class Tareas_Controller extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function tareas_crud()
    {

        if( (Auth::user()->rol == "Administrador") ){
            $sql = "SELECT t.id, u1.name tarea_signada, u2.name tarea_solicitud, t.descripcion, t.tipo, t.created_at, t.updated_at  
            FROM tareas t
            inner join users u1 on t.id_user_asignado  = u1.id 
            inner join users u2 on t.id_user_ordeno  = u2.id";
            $datos = DB::connection('mysql')->select($sql);
        }else{
            $sql = "SELECT t.id, u1.name tarea_signada, u2.name tarea_solicitud, t.descripcion, t.tipo, t.created_at, t.updated_at  
            FROM tareas t
            inner join users u1 on t.id_user_asignado  = u1.id 
            inner join users u2 on t.id_user_ordeno  = u2.id 
            where u1.id = " . Auth::user()->id;
            $datos = DB::connection('mysql')->select($sql);
        }

        $user = User::All();

        $noti = Tareas::where('id_user_asignado', Auth::user()->id)
        ->where('tipo', 'Pendiente')->count();

        return view('crud_tareas')
        ->with('items',  $user )
        ->with('noti',  $noti )
        ->with('list',  $datos );
    }
    
    public function registrar_tarea( Request $request )
    {

        $validator = Validator::make($request->all(), [
            'id' => 'nullable|integer',
            'id_user_asignado' => 'required|integer',
            'descripcion' => 'required'
        ]);
        if ($validator->fails()) {
            return Redirect::route('crud_tareas');
        }
        $data = $request->all();
        $data['id_user_ordeno'] = Auth::user()->id;

        DB::beginTransaction();
        try {

            if( is_null( $request->id )){
                Tareas::create( $data );
            }else{
                $upd = Tareas::findorfail($request->id);
                $upd->update($data);
            }
            DB::commit();
        } catch (\Exception $e) {
            return Redirect::route('crud_tareas');
            DB::rollback(); 
        }

        if( (Auth::user()->rol == "Administrador") ){
            $sql = "SELECT t.id, u1.name tarea_signada, u2.name tarea_solicitud, t.descripcion, t.tipo, t.created_at, t.updated_at  
            FROM tareas t
            inner join users u1 on t.id_user_asignado  = u1.id 
            inner join users u2 on t.id_user_ordeno  = u2.id";
            $datos = DB::connection('mysql')->select($sql);
        }else{
            $sql = "SELECT t.id, u1.name tarea_signada, u2.name tarea_solicitud, t.descripcion, t.tipo, t.created_at, t.updated_at  
            FROM tareas t
            inner join users u1 on t.id_user_asignado  = u1.id 
            inner join users u2 on t.id_user_ordeno  = u2.id 
            where u1.id = " . Auth::user()->id;
            $datos = DB::connection('mysql')->select($sql);
        }

        $user = User::All();

        $noti = Tareas::where('id_user_asignado', Auth::user()->id)
        ->where('tipo', 'Pendiente')->count();

        return view('crud_tareas')
        ->with('items',  $user )
        ->with('noti',  $noti )
        ->with('list',  $datos );
    }

    public function borrar_tarea( Request $request )
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return Redirect::route('crud_tareas');
        }

        $existe = Tareas::findorfail($request->id);
        if( is_null($existe) ){
            return Redirect::route('crud_tareas');
        }

        DB::beginTransaction();
        try {
            $existe->delete();
            DB::commit();
        } catch (\Exception $e) {
            return Redirect::route('crud_tareas');
            DB::rollback(); 
        }

        if( (Auth::user()->rol == "Administrador") ){
            $sql = "SELECT t.id, u1.name tarea_signada, u2.name tarea_solicitud, t.descripcion, t.tipo, t.created_at, t.updated_at  
            FROM tareas t
            inner join users u1 on t.id_user_asignado  = u1.id 
            inner join users u2 on t.id_user_ordeno  = u2.id";
            $datos = DB::connection('mysql')->select($sql);
        }else{
            $sql = "SELECT t.id, u1.name tarea_signada, u2.name tarea_solicitud, t.descripcion, t.tipo, t.created_at, t.updated_at  
            FROM tareas t
            inner join users u1 on t.id_user_asignado  = u1.id 
            inner join users u2 on t.id_user_ordeno  = u2.id 
            where u1.id = " . Auth::user()->id;
            $datos = DB::connection('mysql')->select($sql);
        }

        $user = User::All();

        $noti = Tareas::where('id_user_asignado', Auth::user()->id)
        ->where('tipo', 'Pendiente')->count();

        return view('crud_tareas')
        ->with('items',  $user )
        ->with('noti',  $noti )
        ->with('list',  $datos );
    }

    public function edit_tarea(  Request $request )
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return Redirect::route('crud_tareas');
        }

        $existe = Tareas::findorfail($request->id);
        if( is_null($existe) ){
            return Redirect::route('crud_tareas');
        }
        
        return Tareas::where("id", $request->id )->get();
    }

    public function rechazar_tarea( Request $request )
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return Redirect::route('crud_tareas');
        }

        $existe = Tareas::findorfail($request->id);
        if( is_null($existe) ){
            return Redirect::route('crud_tareas');
        }

        $data = $request->all();
        $data['tipo'] = 3;

        DB::beginTransaction();
        try {
            $upd = Tareas::findorfail($request->id);
            $upd->update($data);
            DB::commit();
        } catch (\Exception $e) {
            return Redirect::route('crud_tareas');
            DB::rollback(); 
        }

        if( (Auth::user()->rol == "Administrador") ){
            $sql = "SELECT t.id, u1.name tarea_signada, u2.name tarea_solicitud, t.descripcion, t.tipo, t.created_at, t.updated_at  
            FROM tareas t
            inner join users u1 on t.id_user_asignado  = u1.id 
            inner join users u2 on t.id_user_ordeno  = u2.id";
            $datos = DB::connection('mysql')->select($sql);
        }else{
            $sql = "SELECT t.id, u1.name tarea_signada, u2.name tarea_solicitud, t.descripcion, t.tipo, t.created_at, t.updated_at  
            FROM tareas t
            inner join users u1 on t.id_user_asignado  = u1.id 
            inner join users u2 on t.id_user_ordeno  = u2.id 
            where u1.id = " . Auth::user()->id;
            $datos = DB::connection('mysql')->select($sql);
        }

        $user = User::All();

        $noti = Tareas::where('id_user_asignado', Auth::user()->id)
        ->where('tipo', 'Pendiente')->count();

        return view('crud_tareas')
        ->with('items',  $user )
        ->with('noti',  $noti )
        ->with('list',  $datos );
    }

    public function finalizado_tarea( Request $request )
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return Redirect::route('crud_tareas');
        }

        $existe = Tareas::findorfail($request->id);
        if( is_null($existe) ){
            return Redirect::route('crud_tareas');
        }

        $data = $request->all();
        $data['tipo'] = 2;

        DB::beginTransaction();
        try {
            $upd = Tareas::findorfail($request->id);
            $upd->update($data);
            DB::commit();
        } catch (\Exception $e) {
            return Redirect::route('crud_tareas');
            DB::rollback(); 
        }

        if( (Auth::user()->rol == "Administrador") ){
            $sql = "SELECT t.id, u1.name tarea_signada, u2.name tarea_solicitud, t.descripcion, t.tipo, t.created_at, t.updated_at  
            FROM tareas t
            inner join users u1 on t.id_user_asignado  = u1.id 
            inner join users u2 on t.id_user_ordeno  = u2.id";
            $datos = DB::connection('mysql')->select($sql);
        }else{
            $sql = "SELECT t.id, u1.name tarea_signada, u2.name tarea_solicitud, t.descripcion, t.tipo, t.created_at, t.updated_at  
            FROM tareas t
            inner join users u1 on t.id_user_asignado  = u1.id 
            inner join users u2 on t.id_user_ordeno  = u2.id 
            where u1.id = " . Auth::user()->id;
            $datos = DB::connection('mysql')->select($sql);
        }

        $user = User::All();

        $noti = Tareas::where('id_user_asignado', Auth::user()->id)
        ->where('tipo', 'Pendiente')->count();

        return view('crud_tareas')
        ->with('items',  $user )
        ->with('noti',  $noti )
        ->with('list',  $datos );
    }

}
