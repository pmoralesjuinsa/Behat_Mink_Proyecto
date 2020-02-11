<?php
namespace Src\Gastos;

require_once __DIR__.'/../../vendor/autoload.php';

use Src\Core\ControllerCore;
use Src\Core\Constants;
use Src\Core\ParamsDTO;

class GastosController extends ControllerCore
{

    public function handler($modulo)
    {
        parent::handler($modulo);

        $paramsDTO = $this->setParams();

        parent::goToTheView($paramsDTO);

    }

    public function setParams()
    {
        $params['modelView'] = new GastosView();
        $params['model'] = $this->setObj();
        $params['userData'] = parent::helperUserData();
        $params['myNamespace'] = 'Src\Gastos\GastosModel';
        $params['modulo'] = Constants::MODULO_GASTOS;

        return new ParamsDTO($params);
    }

    public function setObj()
    {
        $obj = new GastosModel();
        return $obj;
    }

}