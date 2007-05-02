<?php

/**
 * Subclass for representing a row from the 'evento' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Evento extends BaseEvento
{

    function getHoraInicio() {
        // si la hora de ambos es diferente de 00:00:00 entonces si tiene hora
    }


    function getHoraFin() {
        // si la hora de ambos es diferente de 00:00:00 entonces si tiene hora
    }

/*

  protected function getEventoOrCreate($id = 'id')  {
    if (!$this->getRequestParameter($id)) {
        $evento = new Evento();
    } else {
      $evento = EventoPeer::retrieveByPk($this->getRequestParameter($id));
      $this->forward404Unless($evento);
    }
    return $evento;
  }




    protected function updateEventoFromRequest($request, $culture) {
        $evento = $request->getRequestParameter('evento');

        if (isset($evento['fecha_inicio'])) {
            if ($evento['fecha_inicio']) {
                try {
                    $dateFormat = new sfDateFormat($culture);
                    if(!is_array($evento['fecha_inicio'])) {

                        if(isset($evento['hora_asociada']) AND $evento['hora_asociada'] == 1) {
                            if($evento['hora_inicio']) {
                                $evento['fecha_inicio'] .= " ".$evento['hora_inicio']['hour'].":".$evento['hora_inicio']['minute'];
                            } else {
                                $evento['fecha_inicio'] .= " 00:00:00";
                            }
                        } else {
                            $evento['fecha_inicio'] .= " 00:00:00";
                        }

                        $value = $dateFormat->format($evento['fecha_inicio'], 'I', $dateFormat->getInputPattern('g'));
                    } else {
                        $value_array = $evento['fecha_inicio'];
                        
                        $value_array['hour']['hour'] = "00";
                        $value_array['hour']['minute'] = "00";
                        $value_array['hour']['second'] = "00";
                        if($evento['hora_asociada'] == 1) {
                            if($evento['hora_inicio']) {
                                $value_array['hour'] = $evento['hora_inicio']['hour'];
                                $value_array['minute'] = $evento['hora_inicio']['minute'];
                            }
                        } 

                        $value = $value_array['year'].'-'.$value_array['month'].'-'.$value_array['day'].(isset($value_array['hour']) ? ' '.$value_array['hour'].':'.$value_array['minute'].(isset($value_array['second']) ? ':'.$value_array['second'] : '') : '');
                    }

                    $this->evento->setFechaInicio($value);
                }
                catch (sfException $e) {
                // not a date
                }
            } else {
                $this->evento->setFechaInicio(null);
            }
        }

        if (isset($evento['fecha_fin'])) {
            if ($evento['fecha_fin']) {
                try {
                    $dateFormat = new sfDateFormat($this->getUser()->getCulture());
                    if (!is_array($evento['fecha_fin'])) {

                        if(isset($evento['hora_asociada']) AND $evento['hora_asociada'] == 1) {
                            if($evento['hora_fin']) {
                                $evento['fecha_fin'] .= " ".$evento['hora_fin']['hour'].":".$evento['hora_fin']['minute'];
                            } else {
                                $evento['fecha_fin'] .= " 00:00:00";
                            }
                        } else {
                            $evento['fecha_fin'] .= " 00:00:00";
                        }

                        $value = $dateFormat->format($evento['fecha_fin'], 'I', $dateFormat->getInputPattern('g'));
                    } else {
                        $value_array = $evento['fecha_fin'];

                        $value_array['hour']['hour'] = "00";
                        $value_array['hour']['minute'] = "00";
                        $value_array['hour']['second'] = "00";
                        if($evento['hora_asociada'] == 1) {
                            if($evento['hora_fin']) {
                                $value_array['hour'] = $evento['hora_fin']['hour'];
                                $value_array['minute'] = $evento['hora_fin']['minute'];
                            }
                        } 

                        $value = $value_array['year'].'-'.$value_array['month'].'-'.$value_array['day'].(isset($value_array['hour']) ? ' '.$value_array['hour'].':'.$value_array['minute'].(isset($value_array['second']) ? ':'.$value_array['second'] : '') : '');
                    }
                    $this->evento->setFechaFin($value);
                }
                catch (sfException $e) {
                // not a date
                }
            } else {
                $this->evento->setFechaFin(null);
            }
        }


        if(isset($evento['titulo'])) {
            $this->evento->setTitulo($evento['titulo']);
        }
        

        if(isset($evento['tipo'])) {
            $this->evento->setTipo($evento['titulo']);
        } else {
            $this->evento->setTipo(1); //  (0 = PRIVATE | 1 = PUBLIC | 2 = CONFIDENTIAL)
        }

        if(isset($evento['estado'])) {
            $this->evento->setEstado($evento['estado']);
        } else {
            $this->evento->setEstado(1);  // (0 = TENTATIVE, 1 = CONFIRMED, 2 = CANCELLED)
        }




        if(isset($evento['activar_repeticion']) AND $evento['activar_repeticion'] == 1) {
            if(isset($evento['frecuencia']) AND is_array($evento['frecuencia']) ) {
                $this->evento->setFrecuencia($evento['frecuencia'][0]);
                
                switch($evento['frecuencia'][0]) { // dia: 4, semana: 5, mes: 6, año: 7
                    case '4':  $this->evento->setFrecuenciaIntervalo($evento['frecuencia_intervalo_diaria']);
                               break;
                    case '5':  $this->evento->setFrecuenciaIntervalo($evento['frecuencia_intervalo_semana']);
                               $aSemanaBinario = array ( 1, 2, 4, 8, 16, 32, 64 );
                               $suma_total = 0;
                               foreach($evento['recurrencia_dias'] as $dia) {
                                    $suma_total += $aSemanaBinario[$dia];
                               }
                                // guardamos en binario para saber todos los dias de la semana seleccionados
                               $this->evento->setRecurrenciaDias($suma_total); 
                               break;
                    case '6':  break;
                    case '7':  break;
                }
            }
            
            switch($evento['recurrencia_fin_tipo'][0]) {
                case '0':   $this->evento->setRecurrenciaFin(''); 
                            break;
                case '1':   $this->evento->setRecurrenciaFin($evento['recurrencia_fin_repeticion']);
                            break;
                case '2':   $dateFormat = new sfDateFormat($this->getUser()->getCulture());
                            $value = $dateFormat->format($evento['recurrencia_fin_fecha']." 00:00:00", 'I', $dateFormat->getInputPattern('g'));
                            $this->evento->setRecurrenciaFin($value);
                            break; 
            }
       }

  }



*/

}
?>