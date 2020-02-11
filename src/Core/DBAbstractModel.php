<?php

namespace Src\Core;

use Mysqli;

abstract class DBAbstractModel
{

    private static $db_host = 'elalias';
    private static $db_user = 'root';
    private static $db_pass = '123456';
    protected $db_name = 'retoRefac';
    protected $query;
    protected $rows = array();
    private $conn;
    public $mensaje = 'Hecho';

    # métodos abstractos para ABM de clases que hereden
    abstract protected function get();
    abstract protected function set();
    abstract protected function edit();
    abstract protected function delete();

    # los siguientes métodos pueden definirse con exactitud y
    # no son abstractos

    # Conectar a la base de datos
    protected function open_connection($bd_type = null) {

        if(is_null($bd_type)) {
            $this->conn = new \SQLite3(__DIR__."/Db/SqlLite.db");
        } else {
            $this->conn = new mysqli(self::$db_host, self::$db_user, self::$db_pass, $this->db_name);
        }

    }

    # Desconectar la base de datos
    protected function close_connection() {
        $this->conn->close();
    }

    # Ejecutar un query simple del tipo INSERT, DELETE, UPDATE
    public function execute_single_query() {
        $bien_o_mal = false;
        if($_POST) {
            $this->open_connection();
            $bien_o_mal = $this->conn->query($this->query);
            $this->close_connection();
        } else {
            $this->mensaje = 'Metodo no permitido';
        }

        return $bien_o_mal;
    }

    # Traer resultados de una consulta en un Array
    public function get_results_from_query() {
        $this->open_connection();
        $result = $this->conn->query($this->query);
        while ($this->rows[] = $result->fetch_assoc());
        $result->close();
        $this->close_connection();
        array_pop($this->rows);
    }

    protected function buildQueryCheckingVars($user_data, $model, $table, $action)
    {
        $allowed_vars=get_class_vars(get_class($model));
        $vars_are_ok = Tools::checkIfObligatoriesColumnsArePresent($model->obligatorias, $user_data);

        if ($vars_are_ok) {

            switch ($action) {
                case 'edit':
                    $this->buildEditQuery($user_data, $allowed_vars, $table);
                    break;
                case 'insert':
                    $this->buildInsertQuery($user_data, $allowed_vars, $table);
                    break;
            }

        } else {
            $this->mensaje = 'Datos insuficientes. No se han agregado nuevos datos.';
        }
    }

    protected function buildInsertQuery($user_data, $allowed_vars, $table)
    {

        foreach ($user_data as $campo=>$valor) {
            if(array_key_exists($campo, $allowed_vars) && !empty($valor)) {
                $keys[] = $campo;
                $values[] = $valor;
            }
        }

        $this->query = "
                        INSERT INTO
                        $table
                        (".implode(",", $keys).")
                        VALUES
                        ('".implode("','", $values)."')
                        ";
    }

    protected function buildEditQuery($user_data, $allowed_vars, $table)
    {
        $row_string = '';
        $id = $user_data['id'];

        foreach ($user_data as $campo=>$valor) {
            if($campo != 'id' && array_key_exists($campo, $allowed_vars) && !empty($valor)) {
                $row_string .= $campo."='".$valor."', ";
            }
        }

        $row_string = rtrim($row_string, ", ");

        $this->query = "
                    UPDATE
                        $table
                    SET
                        $row_string
                    WHERE
                        id = $id
                    ";
    }

}