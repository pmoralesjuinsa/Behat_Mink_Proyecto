<?php


namespace Src\Gastos;

use Src\Core\DBAbstractModel;

class GastosListModel extends DBAbstractModel
{
    public $gastos_list = array();

    public function get() {

        $hoy = date('Y-m-d');
        $hoyArray = explode("-",$hoy);
        $mes_hoy = $hoyArray[1];
        $anio_hoy = $hoyArray[0];

        $this->query = "
                        SELECT
                            g.*, tg.nombre as nombre_gasto
                        FROM
                            gastos g
                        LEFT JOIN
                                tipo_gastos tg
                                    ON g.id_tipo_gastos = tg.id
                        WHERE                             
                            g.fecha BETWEEN
                                strftime('$anio_hoy-$mes_hoy-01 00:00:00') AND
                                strftime('$hoy 00:00:00')
                        ";

        $this->get_results_from_query();

        if(count($this->rows) >= 1) {
            $this->gastos_list = $this->rows;
        }

    }

    function set(){}
    function delete(){}
    function edit(){}
}