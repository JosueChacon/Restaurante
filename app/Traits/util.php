<?php

namespace App\Traits;

use App\Recibo;

trait util
{
    public function VentasDiariasTrabajador($idtrabajador)
    {
        $recibosEmitidos = Recibo::where('estado', '=', '1')
            ->whereRaw('date(fecha)="' . date('Y-m-d') . '"')
            // ->where('idtipopago', '=', '1')
            ->where('idtrabajador', '=', $idtrabajador)->get();
        $total = 0;
        foreach ($recibosEmitidos as $row) {
            $total += $row['efectivo'];
        }
        return $total;
    }

    public function VDTrabajadorTarjeta($idtrabajador)
    {
        $recibosEmitidos = Recibo::where('estado', '=', '1')
            ->whereRaw('date(fecha)="' . date('Y-m-d') . '"')
            // ->where('idtipopago', '=', '2')
            ->where('idtrabajador', '=', $idtrabajador)->get();
        $total = 0;
        foreach ($recibosEmitidos as $row) {
            $total += $row['tarjeta'];
        }
        return $total;
    }

    public function obtenerNombreMes($mes)
    {
        if ($mes == 1) {
            return "enero";
        } else if ($mes == 2) {
            return "febrero";
        } else if ($mes == 3) {
            return "marzo";
        } else if ($mes == 4) {
            return "abril";
        } else if ($mes == 5) {
            return "mayo";
        } else if ($mes == 6) {
            return "junio";
        } else if ($mes == 7) {
            return "julio";
        } else if ($mes == 8) {
            return "agosto";
        } else if ($mes == 9) {
            return "septiembre";
        } else if ($mes == 10) {
            return "octubre";
        } else if ($mes == 11) {
            return "noviembre";
        } else {
            return "diciembre";
        }
    }

    public function ObtenerPlantilla()
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
            } else if ($rol == 'CAJERO') { //Rol: Cajero
                $plantilla = 'layout.plan_cajero'; 
            }
        } else $plantilla = 'layout.plantilla_cliente';
        return $plantilla;
    }    
}
