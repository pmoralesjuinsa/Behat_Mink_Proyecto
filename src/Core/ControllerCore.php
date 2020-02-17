<?php


namespace Src\Core;


abstract class ControllerCore
{
    protected $peticiones;
    protected $event;
    protected $uri;
    protected $params;
    protected $obligatorias;

    public function handler($modulo)
    {
        $this->event = Constants::VIEW_GET;
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->peticiones = array(
            Constants::DB_SET,
            Constants::DB_GET,
            Constants::DB_DELETE,
            Constants::DB_EDIT,
            Constants::VIEW_SET,
            Constants::VIEW_GET,
            Constants::VIEW_DELETE,
            Constants::VIEW_EDIT
        );

        foreach ($this->peticiones as $peticion) {
            $uri_peticion = $modulo . $peticion . '/';
            if (strpos($this->uri, $uri_peticion) == true) {
                $this->event = $peticion;
            }
        }
    }

    public function goToTheView($paramsDTO)
    {
        $this->params = $paramsDTO;

        switch ($this->event) {
            case Constants::DB_SET:
            case Constants::VIEW_SET:
                $this->goToSetView();
                break;
            case Constants::DB_GET:
                $this->goToGetView();
                break;
            case Constants::DB_DELETE:
            case Constants::VIEW_DELETE:
                $this->goToDeleteView();
                break;
            case Constants::DB_EDIT:
                $this->goToEditView();
                break;
            default:
                $this->gotoDefaultView();
        }
    }

    function goToSetView()
    {
        $data = $this->putDataFromModelResult();
        $this->replaceValueOfForeignKeyToSelector($data);
        $data['mensaje'] = "Añadir nuevo";

        if($this->event == Constants::DB_SET) {

            $vars_are_ok = Tools::checkIfObligatoriesColumnsArePresent(
                $this->params->getModel()->obligatorias,
                $this->params->getUserData()
            );

            if ($vars_are_ok) {
                $this->params->getModel()->set($this->params->getUserData());
                $data['mensaje'] = $this->params->getModel()->mensaje;
            } else {
                $data['mensaje'] = 'Datos insuficientes. No se ha agregado nada.';
            }

        }


        print $this->params->getModelView()->retornar_vista(Constants::VIEW_SET, $this->params->getModulo(), $data);
    }

    function goToGetView()
    {
        $this->params->getModel()->get($this->params->getUserData());

        $data = $this->putDataFromModelResult();

        $this->replaceValueOfForeignKeyToSelector($data);

        print $this->params->getModelView()->retornar_vista(Constants::VIEW_EDIT, $this->params->getModulo(), $data);
    }

    function putDataFromModelResult()
    {
        $reflection = new \ReflectionClass($this->params->getModel());
        $all_class_vars = $reflection->getProperties();

        return $this->filterAllVarsToMyClassVars($all_class_vars);
    }

    function filterAllVarsToMyClassVars($all_class_vars)
    {
        $data = [];
        foreach ($all_class_vars as $class_var) {

            if ($class_var->class === $this->params->getMyNamespace()) {

                $name_var = $class_var->getName();

                if ($name_var == 'fecha') {
                    $data[$class_var->getName()] = date("Y-m-d", strtotime($this->params->getModel()->$name_var));
                } else {
                    $data[$class_var->getName()] = $this->params->getModel()->$name_var;
                }

            }
        }

        return $data;
    }

    protected function replaceValueOfForeignKeyToSelector(&$data)
    {
        $dataKeys = array_keys($data);

        foreach ($dataKeys as $key) {
            if (preg_match("/^id_(.*)/", $key, $match)) {

                $className = $this->convertToCapitalizeString($match[1]);
                $namespacePath = "\Src\TipoGastos\\" . $className;
                $modelName = $namespacePath . "Model";

                $modelListData = new $modelName();
                $modelListData->getAll();

                $listValues = $modelListData->data_list;

                $originalValue = $data[$key];
                $nameRow = $modelListData->htmlSelectorNameRow;

                $this->composeSelectorHtmlForForeignKey($data, $key, $listValues, $originalValue, $nameRow);
            }
        }
    }

    protected function convertToCapitalizeString($string)
    {
        $stringArray = explode("_", $string);

        $stringCapitalized = '';

        foreach ($stringArray as $item) {
            $stringCapitalized .= ucfirst($item);
        }

        return $stringCapitalized;
    }

    /**
     * @param $data
     * @param $key
     * @param array $listValues
     * @param $originalValue
     */
    protected function composeSelectorHtmlForForeignKey(&$data, $key, array $listValues, $originalValue, $nameRow)
    {
        $data[$key] = "<div class='form_requerid'>";
        $data[$key] .= "<select name='" . $key . "' id='" . $key . "'>";

        foreach ($listValues as $item) {
            if ($originalValue == $item['id']) {
                $data[$key] .= "<option selected value='" . $item['id'] . "'>" . $item[$nameRow] . "</option>";
            } else {
                $data[$key] .= "<option value='" . $item['id'] . "'>" . $item[$nameRow] . "</option>";
            }
        }

        $data[$key] .= "</select></div>";
    }

    function goToDeleteView()
    {
        if($this->event == Constants::DB_DELETE) {
            $this->params->getModel()->delete($this->params->getUserData()['id']);
            $data['mensaje'] = $this->params->getModel()->mensaje;
        } else {
            $data['mensaje'] = "Eliminar";
        }

        print $this->params->getModelView()->retornar_vista(Constants::VIEW_DELETE, $this->params->getModulo(), $data);
    }

    function goToEditView()
    {
        $this->params->getModel()->edit($this->params->getUserData());
        $data = array('mensaje' => $this->params->getModel()->mensaje);
        $this->params->getModel()->getAll();
        $data['lista'] = $this->params->getModel()->data_list;
        print $this->params->getModelView()->retornar_vista(Constants::VIEW_GET, $this->params->getModulo(), $data);
    }

    function goToDefaultView()
    {
        $this->params->getModel()->getAll();
        $data['lista'] = $this->params->getModel()->data_list;
        $data['mensaje'] = "Listado del mes";

        print $this->params->getModelView()->retornar_vista($this->event, $this->params->getModulo(), $data);
    }

    public function helperUserData()
    {
        $user_data = array();
        if ($_POST) {
            foreach ($_POST as $key => $value) {
                $user_data[$key] = $value;
            }

        } else {
            if ($_GET) {
                if (array_key_exists('id', $_GET)) {
                    $user_data['id'] = $_GET['id'];
                }
            }
        }
        return $user_data;
    }


}