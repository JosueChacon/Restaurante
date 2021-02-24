<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Cargo;
use App\Cliente;
use App\Persona;
use App\Recibo;
use App\Trabajador;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

//Nuevo
use Yajra\Datatables\Datatables;

class TrabajadorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $trabajadores = Trabajador::where('estado', '=', '1')->get();
        return view('administrador.trabajador.index', compact('trabajadores'));
    }

    public function ListaTrabajadores()
    {
        $trabajadores = DB::table('trabajadores as tr')
            ->Join('personas as pr', 'tr.idpersona', '=', 'pr.idpersona')
            ->Join('cargos as cr', 'tr.idcargo', '=', 'cr.idcargo')
            ->Join('users as us', 'pr.idpersona', '=', 'us.idpersona')
            ->select(
                'tr.idtrabajador',
                DB::raw("concat(pr.nombres,' ',pr.apellidos) as nombrecompleto"),
                'pr.direccion',
                'pr.celular',
                'us.name as usuario',
                'cr.descripcion as cargo'
            )
            ->get();

        return Datatables::of($trabajadores)
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cargos = Cargo::where('descripcion', '!=', 'ADMINISTRADOR')->get();
        return view('administrador.trabajador.create', compact('cargos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = request()->validate(
            [
                'name' => ['unique:users'],
                'password' => ['min:8', 'confirmed'],
            ],
            [
                'name.unique' => 'Ingrese un usuario diferente',
                'password.min' => 'Debe ingresar por lo menos 8 caracteres',
            ]
        );

        $claves = User::all();
        foreach ($claves as $clave) {
            $existe = 0;
            if (password_verify($request->password, $clave['password'])) {
                $existe = 1;
                break;
            }
        }
        if ($existe == 1) {
            return back()
                ->withErrors(['password' => 'Ingrese otra clave'])
                ->withInput(request(['dni', 'nombres', 'apellidos', 'celular', 'direccion', 'email', 'name', 'password']));
        }

        try {
            DB::beginTransaction();
            $persona = new Persona();
            $persona->nombres = $request->nombres;
            $persona->apellidos = $request->apellidos;
            $persona->direccion = $request->direccion;
            $persona->celular = $request->celular;
            $persona->estado = 1;
            $persona->dni = $request->dni;
            $persona->email = $request->email;
            $persona->save();

            $trabajador = new Trabajador();
            $trabajador->idpersona = $persona->idpersona;
            $trabajador->idcargo = $request->idcargo;
            $trabajador->save();

            $user = new User();
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->idtipousuario = 1; //1: TRABAJADOR
            $user->idpersona = $persona->idpersona;
            $user->save();

            //Si se registra un CAJERO, se crea su caja
            if ($request->idcargo == 4) {
                $caja = new Caja();
                $caja->id = $user->id;
                $caja->save();
            }
            DB::commit();
            $cargo = Cargo::findorfail($request->idcargo);
            return redirect()->route('MiGente.index')->with('good', $cargo['descripcion'] . ' guardado con éxito');
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //        
        $trabajador = Trabajador::findorfail($id);
        $cargos = Cargo::where('descripcion', '!=', 'ADMINISTRADOR')->get();
        return view('administrador.trabajador.edit', compact('cargos', 'trabajador'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = request()->validate(
            [
                'password' => ['min:8', 'confirmed'],
            ],
            [
                'password.min' => 'Debe ingresar por lo menos 8 caracteres',
            ]
        );

        try {
            DB::beginTransaction();
            $trabajador = Trabajador::findorfail($id);

            $claves = User::all();
            foreach ($claves as $clave) {
                $existe = 0;
                if (password_verify($request->password, $clave['password'])) {
                    $existe = 1;
                    break;
                }
            }
            if ($existe == 1) {
                return back()
                    ->withErrors(['password' => 'Ingrese otra clave'])
                    ->withInput(request(['dni', 'nombres', 'apellidos', 'celular', 'direccion', 'email', 'name', 'password']));
            }

            $persona = $trabajador->Persona;
            $persona->nombres = $request->nombres;
            $persona->apellidos = $request->apellidos;
            $persona->direccion = $request->direccion;
            $persona->celular = $request->celular;
            $persona->dni = $request->dni;
            $persona->email = $request->email;
            $persona->save();

            $user = $trabajador->Persona->User;
            $user->password = Hash::make($request->password);
            $user->save();

            DB::commit();
            $cargo = Cargo::findorfail($trabajador->idcargo);
            return redirect()->route('MiGente.index')->with('good', $cargo['descripcion'] . ' guardado con éxito');
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trabajador = Trabajador::findorfail($id);
        $trabajador->estado = 0;
        $trabajador->save();
        $user = $trabajador->Persona->User;
        $user->estado = 0;
        $user->save();
        if ($trabajador->Cargo->idcargo == 4) {            
            $caja = $user->Caja;
            $caja->estado_delete = 0;
            $caja->save();
        }

        return ['rpta' => 'ok'];
    }

    public function ListaTrabajadores_()
    {        
        $trabajadores = Trabajador::all();
        return view('administrador.trabajador.listadoTrabajadores', compact('trabajadores'));
    }

    //CLIENTE:
    public function ListaClientes(Request $request)
    {
        $buscarpor = $request->buscarpor;

        $clientes = cliente::join('personas', 'clientes.idpersona', '=', 'personas.idpersona')
            ->where('clientes.estado', '=', '1')
            ->where('personas.apellidos', 'like', '%' . $buscarpor . '%')
            ->paginate(5);
        return view('administrador.cliente.listadoClientes', compact('clientes', 'buscarpor'));
    }

    public function ListaRecibos(Request $request)
    {
        $desde = $request->desde;
        $hasta = $request->hasta;
        $idcliente = $request->idcliente;

        if ($desde != null && $hasta != null) {
            $data = explode('/', $desde);
            $ndesde = $data[2] . '-' . $data[1] . '-' . $data[0];
            $data = explode('/', $hasta);
            $nhasta = $data[2] . '-' . $data[1] . '-' . $data[0];

            $cliente = null;
            if ($idcliente != null) {
                $cliente = Cliente::findorfail($idcliente);
                $recibos = Recibo::where('estado', '=', '1')
                    ->where('idcliente', '=', $idcliente)
                    ->whereraw('"' . $ndesde . '"<=date(fecha) and date(fecha)<="' . $nhasta . '"')
                    ->orderBy('fecha', 'DESC')
                    ->paginate(10);
            } else {
                $recibos = Recibo::where('estado', '=', '1')
                    ->whereraw('"' . $ndesde . '"<=date(fecha) and date(fecha)<="' . $nhasta . '"')
                    ->orderBy('fecha', 'DESC')
                    ->paginate(10);
            }
        } else {
            $desde = date('d/m/Y');
            $hasta = date('d/m/Y');
            $cliente = null;
            $recibos = Recibo::where('estado', '=', '1')
                ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
                ->orderBy('fecha', 'DESC')
                ->paginate(10);
        }
        $clientes = Cliente::all();
        $total = 0;
        foreach ($recibos as $item) $total += $item['total'];
        return view('administrador.recibo.listadoRecibos', compact(
            'recibos',
            'clientes',
            'desde',
            'hasta',
            'cliente',
            'total'
        ));
    }

    public function MontoEnCaja(Request $request)
    {
        $now = date('Y-m-d');
        $idcaja = $request->idcaja;
        $total = 0;
        if ($idcaja != 0) {
            $caja = Caja::findorfail($idcaja);
            $idtrabajador = $caja->Usuario->Persona->Trabajador->idtrabajador;
            $recibosT = Recibo::where('estado', '=', '1')
                ->whereRaw('date(fecha)="' . date('Y-m-d') . '"')
                ->orderBy('fecha', 'DESC')
                ->where('idtrabajador', '=', $idtrabajador)
                ->get();
            foreach ($recibosT as $rT) $total += $rT['total'];
            $recibos = Recibo::where('estado', '=', '1')
                ->whereRaw('date(fecha)="' . date('Y-m-d') . '"')
                ->orderBy('fecha', 'DESC')
                ->where('idtrabajador', '=', $idtrabajador)
                ->paginate(10);
        } else {
            $idcaja = 0;
            $recibosT = Recibo::where('estado', '=', '1')
                ->whereRaw('date(fecha)="' . date('Y-m-d') . '"')
                ->orderBy('fecha', 'DESC')
                ->get();
            foreach ($recibosT as $rT) $total += $rT['total'];
            $recibos = Recibo::where('estado', '=', '1')
                ->whereRaw('date(fecha)="' . date('Y-m-d') . '"')
                ->orderBy('fecha', 'DESC')
                ->paginate(10);
        }
        $cajas = Caja::where('estado_delete', '=', '1')->get();
        return view('administrador.recibo.listadoRecibosHoy', compact('recibos', 'total', 'cajas', 'idcaja'));
    }

    public function ClavePersonal()
    {
        $trabajadores = Trabajador::paginate(4);
        return view('administrador.trabajador.cambiarclave', compact('trabajadores'));
    }

    public function CambiarClavePersonal(Request $request)
    {
        $name = auth()->user()->name;
        $query = User::where('name', '=', $name)->get();
        if ($query->count() != 0) {
            $hashp = $query[0]->password;
            $password = $request->clave_admin;
            if (password_verify($password, $hashp)) {
                //actualiza datos de usuario
                $id = $request->id;
                $clave = $request->clave;
                $user = User::findorfail($id);
                $user->password = Hash::make($clave);
                $user->save();
                return redirect()->route('ClavePersonal')->with('good', "Clave modificada de: " . "'$user->name'");
            }
            return redirect()->route('ClavePersonal')->with('error', 'Clave de administrador incorrecta');
        }
        return redirect()->route('ClavePersonal')->with('error', 'El usuario ya no está disponible');
    }


    //
    public function foto($id)
    {
        $trabajador = Trabajador::findorfail($id);
        return view('administrador.trabajador.cambiarfoto', compact('trabajador'));
    }

    public function storeFoto(Request $request, $id)
    {
        $data = request()->validate(
            [
                'foto' => 'image',
            ],
            [
                'foto.image' => 'El tipo de documento no es admitido',
            ]
        );

        $trabajador = Trabajador::findorfail($id);

        $file = $request->file('foto');
        $nombre = 'user_' . $trabajador->Persona->User->id . '.' . $file->getClientOriginalExtension();
        Storage::disk('perfil_user')->put($nombre, File::get($file));

        $user = $trabajador->Persona->User;
        $user->foto = $nombre;
        $user->save();

        $cargo = $trabajador->Cargo;
        return redirect()->route('MiGente.index')->with('good', 'Foto de ' . $cargo['descripcion'] . ' actualizada');
    }
}
