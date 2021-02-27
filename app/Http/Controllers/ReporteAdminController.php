<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Programacion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class ReporteAdminController extends Controller
{
    public function StockProductos()
    {
        $productos = Producto::where('estado', '=', '1')->get();
        $total_productos = 0;
        foreach ($productos as $p) $total_productos += $p->stock;
        $pdf = PDF::loadView('reportes.ImprimirStockProducto', compact('productos', 'total_productos'));
        $pdf->setpaper([0, 0, 210, 450]);
        return $pdf->stream('Reporte_SAProductos-' . date('d-m-Y') . '.pdf');
    }

    public function StockPlatos()
    {
        $programacion = Programacion::where('estado', '=', '1')
            ->whereraw('date(fecha)="' . date('Y-m-d') . '"')
            ->orderby('fecha', 'desc')->first();
        if ($programacion == null) {
            return redirect()->route('home')->with('error', 'No hay una programación para hoy');
        }
        $total_platos = 0;
        foreach ($programacion->DProgramacion as $detalle) {
            $total_platos += $detalle['stock'];
        }
        $pdf = PDF::loadView('reportes.ImprimirStockPlatos', compact('programacion', 'total_platos'));
        $pdf->setpaper([0, 0, 210, 450]);
        return $pdf->stream('Reporte_SAPlatos-' . date('d-m-Y') . '.pdf');
    }
}
