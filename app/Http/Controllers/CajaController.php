<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Movimiento;
use App\Trabajador;
use App\Traits\util;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CajaController extends Controller
{
    use util;
    public function AperturarCaja()
    {
        $plantilla = auth()->user()->ObtenerPlantilla();
        if ($plantilla == 'layout.plan_cajero') {
            $cajas = Caja::where('estado_delete', '=', '1')
                ->where('id', '=', Auth::id())->get();
            $cajas_aperturadas = Movimiento::where('estado_delete', '=', '1')
                ->whereraw('date(fecha_inicio)="' . date('Y-m-d') . '"')
                ->where('idcaja', '=', $cajas[0]['idcaja'])
                ->get();
        } else {
            $cajas = Caja::where('estado_delete', '=', '1')->get();
            $cajas_aperturadas = Movimiento::where('estado_delete', '=', '1')
                ->whereraw('date(fecha_inicio)="' . date('Y-m-d') . '"')
                ->get();
        }

        $total_aperturado = 0;
        foreach ($cajas_aperturadas as $ca) $total_aperturado += $ca['monto_inicio'];
        return view('administrador.caja.abrircaja', compact(
            'cajas',
            'plantilla',
            'cajas_aperturadas',
            'total_aperturado'
        ));
    }

    public function Aperturar(Request $request)
    {
        $idcaja = $request->idcaja;
        $movimiento = Movimiento::where('estado_delete', '=', '1')
            ->whereraw('date(fecha_inicio)="' . date('Y-m-d') . '"')
            ->where('idcaja', '=', $idcaja)->first();
        if ($movimiento != null) {
            if ($movimiento->estado == 'CERRADA') {
                return back()
                    ->with('error', 'No puede aperturar, la caja ya ha sido cerrada')
                    ->withInput(request(['monto_inicial']));
            }
            return back()
                ->with('error', 'No puede aperturar, la caja ya ha sido apertudada')
                ->withInput(request(['monto_inicial']));
        }

        $data = request()->validate(
            [
                'idcaja' => 'required',
                'monto_inicial' => 'required',
            ],
            [
                'monto_inicial.required' => 'Ingrese monto'
            ]
        );
        $idcaja = $request->idcaja;
        $monto_inicio = $request->monto_inicial;
        $movimiento = new Movimiento();
        $movimiento->monto_inicio = $monto_inicio;
        $movimiento->fecha_inicio = date('Y-m-d H:i:s');
        $movimiento->estado = "APERTURADA";
        $movimiento->idcaja = $idcaja;
        $movimiento->id = Auth::id();
        $movimiento->save();
        return redirect()->route('aperturarcaja')
            ->with('good', 'Caja ' . $idcaja . ' aperturada con éxito');
    }


    public function CerrarCaja(Request $request)
    {
        $plantilla = auth()->user()->ObtenerPlantilla();
        //Si es cajero... mostrar sólo sus datos
        if ($plantilla == 'layout.plan_cajero') {
            $cajas = Caja::where('estado_delete', '=', '1')
                ->where('id', '=', Auth::id())->get();
            $cajas_aperturadas = Movimiento::where('estado_delete', '=', '1')
                ->whereraw('date(fecha_inicio)="' . date('Y-m-d') . '"')
                ->where('idcaja', '=', $cajas[0]['idcaja'])
                ->get();
        } else {
            // $cajas = Caja::where('estado_delete', '=', '1')->get();
            $cajas_aperturadas = Movimiento::where('estado_delete', '=', '1')
                ->whereraw('date(fecha_inicio)="' . date('Y-m-d') . '"')
                ->get();
        }
        $data = [];

        foreach ($cajas_aperturadas as $item) {
            $idtrabajador = $item->Caja->Usuario->Persona->Trabajador['idtrabajador'];
            $row = [
                'caja' => 'Caja ' . $item->idcaja,
                'fecha_inicio' => $item->fecha_inicio->format('h:i a'),
                'fecha_cierre' => $item->fecha_cierre == null ? '-' : $item->fecha_cierre->format('h:i a'),
                'monto_inicio' => number_format($item->monto_inicio, 2),
                'monto_cierre' => $item->monto_cierre == null ? '-' : number_format($item->monto_cierre, 2),
                'efectivo_hoy' => number_format($this->VentasDiariasTrabajador($idtrabajador), 2),
                'tarjeta_hoy' => number_format($this->VDTrabajadorTarjeta($idtrabajador), 2),
                'estado' => $item->estado,
                'cboCaja' => 'Caja ' . $item->idcaja . ':' . $item->Caja->Usuario->Persona->nombres_apellidos(),
                'idmovimiento' => $item->idmovimiento,
            ];
            array_push($data, $row);
        }
        $total_cerrado = 0;
        foreach ($cajas_aperturadas as $caja) {
            if ($caja['estado'] == 'CERRADA') $total_cerrado += $caja['monto_cierre'];
        }
        return view('administrador.caja.cerrarcaja', compact('plantilla', 'data', 'total_cerrado'));
    }

    public function Cerrar(Request $request)
    {
        $movimiento = Movimiento::findorfail($request->idmovimiento);
        $idtrabajador = $movimiento->Caja->Usuario->Persona->Trabajador['idtrabajador'];
        $efectivo_hoy = $this->VentasDiariasTrabajador($idtrabajador);
        $tarjeta_hoy = $this->VDTrabajadorTarjeta($idtrabajador);

        if ($movimiento->estado == 'CERRADA') {
            return redirect()->route('cerrarcaja')
                ->with('error', 'La Caja ' . $movimiento['idcaja'] . ' ya ha sido cerrada');
        }
        $movimiento->monto_cierre = $movimiento['monto_inicio'] + $efectivo_hoy;
        $movimiento->monto_tarjeta = $tarjeta_hoy;
        $movimiento->fecha_cierre = date('Y-m-d H:i:s');
        $movimiento->estado = 'CERRADA';
        $movimiento->save();
        return redirect()->route('cerrarcaja')
            ->with('good', 'Caja ' . $movimiento['idcaja'] . ' cerrada con éxito');
    }

    public function Resumen()
    {
        $mes = $this->obtenerNombreMes(date('m'));
        $trabajadores = Trabajador::all();
        $suma_MI = 0;
        $suma_VD = 0;
        foreach ($trabajadores as $row) {
            $suma_VD += $this->VentasDiariasTrabajador($row['idtrabajador']);
        }

        $movimientos = Movimiento::where('estado_delete', '=', '1')
            ->whereraw('date(fecha_inicio)="' . date('Y-m-d') . '"')->get();
        foreach ($movimientos as $row) {
            $suma_MI += $row['monto_inicio'];
        }

        $total = $suma_MI + $suma_VD;
        return view('administrador.caja.resumencaja', compact('mes', 'suma_MI', 'suma_VD', 'total', 'trabajadores'));
    }
}
