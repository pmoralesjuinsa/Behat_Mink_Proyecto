<?php


namespace Src\TipoGastos;

use Src\Core\DBAbstractModel;

class TipoGastosModel extends DBAbstractModel
{
    public $data_list = array();

    public function getAll()
    {
        $tipoGastosList = new TipoGastosListModel();

        $tipoGastosList->get();

        if (empty($tipoGastosList->tipoGastosList)) {
            return;
        }

        $this->data_list = $tipoGastosList->tipoGastosList;
    }

    function set()
    {

    }

    function get()
    {

    }

    function delete()
    {

    }

    function edit()
    {

    }
}