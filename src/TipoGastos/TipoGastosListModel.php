<?php


namespace Src\TipoGastos;


use Src\Core\DBAbstractModel;

class TipoGastosListModel extends DBAbstractModel
{
    public $tipoGastosList = array();

    public function get() {

        $this->query = "
                        SELECT
                            *
                        FROM
                            tipo_gastos
                        ";

        $this->get_results_from_query();

        if(count($this->rows) >= 1) {
            $this->tipoGastosList = $this->rows;
        }

    }

    function set(){}
    function delete(){}
    function edit(){}
}