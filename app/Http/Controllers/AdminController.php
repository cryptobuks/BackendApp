<?php

namespace App\Http\Controllers;

use App\AdminTable;
use App\Meses;
use App\Received;
use App\Sent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class AdminController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->isMethod('post')) {

            $mail = trim($request->email);
            $pass = trim($request->password);

            $flag = $this->validateLogin($mail, $pass);
            if ($flag == 1) {
                $data = $this->getUserData($mail, $pass);
                Session::put('adminId', $data->id);
                Session::put('adminSession', $data['email']);
                Session::put('adminName', $data['name']);
                return \Redirect::route('admin.dashboard', $data->id);
            } else {
                return view('admin.index', ['error' => 'Usuario o Contraseña Invalidos.', 'id' => '']);
            }

        }
        return view('admin.index', ['id' => '']);
    }


    public function dashboard($id)
    {

        Session::remove('users');

        $data = $this->getUserDataById($id);

        Carbon::setLocale('co');
        $date = \Carbon\Carbon::now();

        $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
            'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $mes = $meses[$date->month - 1];

        $sents = Sent::where('estado', 'P')->get();

        $users = Sent::select('id_user')->from('sents')
            ->groupBy('id_user')
            ->get();

        Session::put('users', count($users));

        $pendientes = Sent::where('estado', 'P')->count();
        $respondidos = Sent::where('estado', 'R')->count();
        $respondidosMes = Sent::where('estado', 'R')
            ->where(DB::raw('MONTH(created_at)'), $date->month)
            ->count();
        $totales = Sent::all()->count();

        $array = [];
        $collectionSents = null;

        foreach ($sents as $sent) {
            array_push($array, (object)array(
                'id' => $sent->id,
                'nombre' => $sent->nombre,
                'asunto' => $sent->asunto,
                'contenido' => $sent->contenido,
                'remitente' => $sent->remitente,
                'ciudad' => $sent->ciudad,
                'estado' => $sent->estado,
                'hora' => $sent->created_at
            ));
        }

        $collectionSents = new Collection($array);

        $mesesTable = Meses::all();


        return view('admin.panel',
            [
                'name' => $data->name,
                'users' => count($users),
                'mes' => $mes,
                'sents' => $collectionSents,
                'pendientes' => $pendientes,
                'total' => $totales,
                'respondidos' => $respondidos,
                'respondidosMes' => $respondidosMes,
                'id' => $id,
                'mesesTable' => $mesesTable,
                'mesNum' => $date->month
            ]
        );
    }

    public function pendientes()
    {
        return $pendientes = Sent::where('estado', 'P')->count();
    }

    public function getResueltos($id)
    {
        $sentsResueltos = Sent::where('estado', 'R')
            ->where(DB::raw('MONTH(created_at)'), $id)
            ->get();

        $arrayResueltos = [];
        $collectionSentsResueltos = null;

        foreach ($sentsResueltos as $sentR) {
            array_push($arrayResueltos, (object)array(
                'id' => $sentR->id,
                'nombre' => $sentR->nombre,
                'asunto' => $sentR->asunto,
                'contenido' => $sentR->contenido,
                'remitente' => $sentR->remitente,
                'estado' => $sentR->estado,
                'hora' => $sentR->created_at
            ));
        }

        $collectionSentsResueltos = new Collection($arrayResueltos);

        return $collectionSentsResueltos;
    }

    public function response($idResponse)
    {
        $users = Session::get('users');
        $name = Session::get('adminName');
        $id = Session::get('adminId');
        $pendientes = Sent::where('estado', 'P')->count();

        $data = $this->getDataSentById($idResponse);

        return view('admin.response',
            [
                'pendientes' => $pendientes,
                'name' => $name,
                'users' => $users,
                'id' => $id,
                'data' => $data,
                'idSent' => $idResponse
            ]
        );
    }


    public function solved($id)
    {
        $users = Session::get('users');
        $idAdmim = Session::get('adminId');
        $pendientes = Sent::where('estado', 'P')->count();
        $sent = Sent::where('id', $id)->first();
        $received = Received::where('id_sent', $id)->first();
        return view('admin.solved',
            [
                'pendientes' => $pendientes,
                'id' => $idAdmim,
                'sent' => $sent,
                'received' => $received,
                'users' => $users,
            ]
        );
    }

    public function logout()
    {
        Session::flush();
        return view('admin.index', ['info' => 'Sesion Cerrada Correctamente!', 'id' => '']);
    }


    private function validateLogin($email, $pass)
    {
        $flag = 1;

        $admin = AdminTable::where('email', $email)
            ->where('password', $pass)
            ->get();


        if ($admin->isEmpty()) {
            $flag = 0;
        }


        return $flag;
    }

    private function getUserData($email, $pass)
    {
        $admin = AdminTable::where('email', $email)
            ->where('password', $pass)
            ->first();

        return $admin;
    }

    private function getUserDataById($id)
    {
        $idUser = trim($id);

        $admin = AdminTable::where('id', $idUser)
            ->first();

        return $admin;
    }

    private function getDataSentById($id)
    {
        $data = Sent::where('id', $id)
            ->first();

        return $data;
    }


}
