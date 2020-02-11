<?php


namespace Src\Ingresos;

use Src\Core\DBAbstractModel;

class IngresosListModel extends DBAbstractModel
{
    public $ingresos_list = array();

    public function get() {

        $hoy = date('Y-m-d');
        $hoyArray = explode("-",$hoy);
        $mes_hoy = $hoyArray[1];
        $anio_hoy = $hoyArray[0];


        $this->query = "
                        SELECT
                            *
                        FROM
                            ingresos
                        WHERE 
                            fecha BETWEEN
                                CAST('$anio_hoy-$mes_hoy-1 00:00:00' AS DATETIME) AND
                                CAST('$hoy 00:00:00' AS DATETIME)
                        ";
        $this->get_results_from_query();

        if(count($this->rows) >= 1) {
            $this->ingresos_list = $this->rows;
        }
    }

    function set(){}
    function delete(){}
    function edit(){}
}