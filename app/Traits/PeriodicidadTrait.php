<?php

namespace App\Traits;

trait PeriodicidadTrait
{
    //---calcula las fechas de la semana según una fecha dada
    public function semana($dia, $mes, $year)
    {
        $fechas = array();
        $fechas=['ini'=>date('Y-m-d'), 'fin'=>date('Y-m-d'), 'semana'=>0];

        if(checkdate($mes, $dia, $year)){
            $semana=date("W",mktime(0,0,0, $mes, $dia, $year)); // Número de semana según de la fecha dada

            $diaSemana=date("w",mktime(0,0,0, $mes, $dia, $year)); // 0 es el domingo
            if($diaSemana==0){ $diaSemana=7; } // A la fecha recibida, le restamos el dia de la semana y obtendremos el lunes
            $primerDia= date("Y-m-d",mktime(0,0,0, $mes, $dia-$diaSemana+1, $year));

            $diaSemana=date("w",mktime(0,0,0, $mes, $dia, $year)); // 0 es domingo
            if($diaSemana==0){ $diaSemana=7; } // A la fecha recibida, le sumamos el dia de la semana menos siete y obtendremos el domingo
            $ultimoDia=date("Y-m-d",mktime(0,0,0, $mes, $dia+(7-$diaSemana), $year));

            $fechas=['ini'=>$primerDia, 'fin'=>$ultimoDia, 'semana'=>$semana];

            return $fechas;
        }
        
        return $fechas;
    }

}