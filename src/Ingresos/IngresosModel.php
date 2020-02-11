<?php

namespace Src\Ingresos;

use Src\Core\DBAbstractModel;

class IngresosModel extends DBAbstractModel
{

    ############################### PROPIEDADES ################################
    public $importe;
    public $id;
    public $nombre;
    public $fecha;
    public $total;
    public $data_list = array();
    public $obligatorias = array('nombre', 'importe');


    ################################# MÉTODOS ##################################

    function getAll() {
        $ingresos_list = new IngresosListModel();
        $ingresos_list->get();
        if(empty($ingresos_list->ingresos_list)) {
            return;
        }

        $this->data_list = $ingresos_list->ingresos_list;
    }

    # Traer datos de los ingreso
    public function get($filters=array()) {

        if(is_array($filters)) {
            $this->query = "
                        SELECT
                            *
                        FROM
                            ingresos                        
                        WHERE
                            id = $filters[id]
                        ";
            $this->get_results_from_query();
        }

        if(count($this->rows) == 1) {
            foreach ($this->rows[0] as $propiedad=>$valor) {
                $this->$propiedad = $valor;
            }
            $this->mensaje = 'Ingresos encontrados';
        } else {
            $this->mensaje = 'Ingresos no encontrados';
        }
    }

    # Crear un nuevo ingreso
    public function set($user_data=array())
    {
        parent::buildQueryCheckingVars($user_data, $this, "ingresos", 'insert');

        if($this->execute_single_query()) {
            $this->mensaje = 'Ingreso agregado exitosamente';
        } else {
            $this->mensaje = 'Ha ocurrido un error al intentar introducir el ingreso';
        }

    }

    # Modificar un ingreso
    public function edit($user_data=array()) {

        parent::buildQueryCheckingVars($user_data, $this, "ingresos", 'edit');

        if($this->execute_single_query()) {
            $this->mensaje = 'Ingreso modificado';
        } else {
            $this->mensaje = 'Ha ocurrido un error al intentar modificar el ingreso';
        }
    }

    # Eliminar un gasto
    public function delete($id=0) {
        $this->query = "
                DELETE FROM
                    ingresos
                WHERE
                    id = $id
                ";

        if($this->execute_single_query()) {
            $this->mensaje = 'Ingreso eliminado';
        } else {
            $this->mensaje = 'Ha ocurrido un error al intentar eliminar el ingreso';
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