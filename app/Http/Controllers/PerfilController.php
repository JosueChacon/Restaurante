<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Mesa;
use App\Pedido;
use App\Persona;
use App\Programacion;
use App\Recibo;
use App\Reserva;
use App\Trabajador;
use App\Traits\util;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PerfilController extends Controller
{
    use util;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function mostrarFrmInicio(Request $request)
    {
        $user = auth()->user();
        $now = date('Y-m-d');
        if ($user->TipoUsuario->idtipousuario == 1) { //1: TRABAJADOR
            $rol = $user->Persona->Trabajador->Cargo->descripcion;
            if ($rol == 'ADMINISTRADOR') {
                $recibos = Recibo::where('estado', '=', '1')
                    ->whereRaw('date(fecha)=' . "'$now'")
                    ->get();
                $total = 0;
                foreach ($recibos as $item) {
                    $total += $item->total;
                }

                $montoencaja = $total;
                $cant_recibos = count($recibos);
                $trabajadores = Trabajador::all();
                $clientes = Cliente::where('estado', '=', '1')->get();
                return view('administrador.principalAdmin', compact('montoencaja', 'cant_recibos', 'trabajadores', 'clientes'));
            } else if ($rol == 'MESERO') {
                $mesas = Mesa::where('estado', '=', '1')->orderby('nromesa', 'DESC')->get();
                $reservas = Reserva::where('estado_delete', '=', '1')->where('estado', '=', 'OCUPADA')
                    ->whereraw('date(fecha)="' . date('Y-m-d') . '"')->get();
                return view('trabajador.p_trabajador', compact('mesas', 'reservas'));
            } else if ($rol == 'COCINERO') {
                $now = date('Y-m-d');
                $pedidos = Pedido::where('estado_delete', '=', '1')
                    ->where('estado', '=', 'Confirmado')
                    ->whereRaw('date(fecha) =' . "'$now'")
                    ->paginate(8);
                return view('cocinero.index', compact('pedidos'));
            } else if ($rol == 'CAJERO') {
                $idtrabajador = $request->idtrabajador;

                $pedidos = pedido::where('estado_delete', '=', '1')
                    ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
                    ->where('estado', '=', 'Atendido')->orderBy('fecha', 'DESC')
                    ->get();

                if ($idtrabajador != null) {
                    if ($idtrabajador == 0) {
                        $pedidos = pedido::where('estado_delete', '=', '1')
                            ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
                            ->where('estado', '=', 'Atendido')->orderBy('fecha', 'DESC')
                            ->get();
                    } else {
                        $pedidos = pedido::where('estado_delete', '=', '1')
                            ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
                            ->where('estado', '=', 'Atendido')->orderBy('fecha', 'DESC')
                            ->where('idtrabajador', '=', $idtrabajador)
                            ->get();
                    }
                }

                $meseros = Trabajador::where('idcargo', '=', '2')->get();
                return view('cajero.index', compact('pedidos', 'idtrabajador', 'meseros'));
            }
        } else { //2: CLIENTE
            $prog = Programacion::where('estado', '=', '1')
                ->whereRaw('date(fecha)=' . "'$now'")
                ->first();
            return view('cliente.p_cliente', compact('prog'));
        }
    }

    public function mostrarFrmFoto()
    {
        $tipo = auth()->user()->TipoUsuario->descripcion;
        if ($tipo == 'TRABAJADOR') {
            $rol = auth()->user()->Persona->Trabajador->Cargo->descripcion;
            if ($rol == 'ADMINISTRADOR') { //Rol: Administrador
                $plantilla = 'layout.plantilla_admin';
            } else if ($rol == 'MESERO') { //Rol: Mesero
                $plantilla = 'layout.plantilla_trabajador';
            } else if ($rol == 'COCINERO') { //Rol: Cocinero
                $plantilla = 'layout.plan_cocinero';
            } else if ($rol == 'CAJERO') {
                $plantilla = 'layout.plan_cajero';
            }
        } else {
            $plantilla = 'layout.plantilla_cliente';
        }
        return view('cambiarfoto', compact('plantilla'));
    }

    public function guardarFoto(Request $request)
    {
        //
        $data = request()->validate(
            [
                'foto' => 'image',
            ],
            [
                'foto.image' => 'El tipo de documento no es admitido',
            ]
        );

        $file = $request->file('foto');
        $nombre = 'user_' . auth()->user()->id . '.' . $file->getClientOriginalExtension();
        Storage::disk('perfil_user')->put($nombre, File::get($file));

        $user = auth()->user();
        $user->foto = $nombre;
        $user->save();

        return redirect()->route('home');
    }
}
