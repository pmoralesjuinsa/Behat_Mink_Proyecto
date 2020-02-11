<?php

namespace Src\Gastos;

use Src\Core\DBAbstractModel;

class GastosModel extends DBAbstractModel
{

    ############################### PROPIEDADES ################################
    public $importe;
    public $cantidad;
    public $id;
    public $fecha;
    public $nota;
    public $id_tipo_gastos;
    public $total;
    public $data_list = array();
    public $obligatorias = array('id_tipo_gastos', 'importe');


    ################################# MÉTODOS ##################################

    function getAll() {
        $gastos_list = new GastosListModel();
        $gastos_list->get();
        if(empty($gastos_list->gastos_list)) {
            return;
        }

        $this->data_list = $gastos_list->gastos_list;
    }

    # Traer datos de los gastos
    public function get($filters=array()) {
        $whereDB = "WHERE $filters = '$filters'"; //TODO where dinámico por filtros

        if(is_array($filters)) {
            $this->query = "
                        SELECT
                            g.*, tg.nombre as nombre_gasto
                        FROM
                            gastos g
                        LEFT JOIN tipo_gastos tg ON g.id_tipo_gastos = tg.id
                        WHERE
                            g.id = $filters[id]
                        ";
            $this->get_results_from_query();
        }

        if(count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {
                $this->$propiedad = $valor;
            }

            $this->total = $this->cantidad * $this->importe;

            $this->mensaje = 'Gastos encontrados';
        } else {
            $this->mensaje = 'Gastos no encontrados';
        }
    }

    # Crear un nuevo gasto
    public function set($user_data=array())
    {
        parent::buildQueryCheckingVars($user_data, $this, "gastos", 'insert');

        if($this->execute_single_query()) {
            $this->mensaje = 'Gasto agregado exitosamente';
        } else {
            $this->mensaje = 'Ha ocurrido un error al intentar introducir el gasto';
        }

    }

    # Modificar un gasto
    public function edit($user_data=array()) {

        parent::buildQueryCheckingVars($user_data, $this, "gastos", 'edit');

        if($this->execute_single_query()) {
            $this->mensaje = 'Gasto modificado';
        } else {
            $this->mensaje = 'Ha ocurrido un error al intentar modificar el gasto';
        }
    }

    # Eliminar un gasto
    public function delete($id=0) {
        $this->query = "
                DELETE FROM
                gastos
                WHERE
                id = '$id'
                ";

        if($this->execute_single_query()) {
            $this->mensaje = 'Gasto eliminado';
        } else {
            $this->mensaje = 'Ha ocurrido un error al intentar eliminar el gasto';
        }
    }

    # Método constructor
    function __construct() {
//        $this->db_name = 'retoRefac';
    }

    # Método destructor del objeto
    function __destruct() {
//        unset($this);
    }

}