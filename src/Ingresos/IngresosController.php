<?php
namespace Src\Ingresos;

require_once __DIR__.'/../../vendor/autoload.php';

use Src\Core\ControllerCore;
use Src\Core\Constants;
use Src\Core\ParamsDTO;

class IngresosController extends ControllerCore
{

    public function handler($modulo)
    {
        parent::handler($modulo);

        $params = $this->setParams();

        parent::goToTheView($params);

    }

    public function setParams()
    {
        $params['modelView'] = new IngresosView();
        $params['model'] = $this->setObj();
        $params['userData'] = parent::helperUserData();
        $params['myNamespace'] = 'Src\Ingresos\IngresosModel';
        $params['modulo'] = Constants::MODULO_INGRESOS;

        return new ParamsDTO($params);
    }

    public function setObj()
    {
        $obj = new IngresosModel();
        return $obj;
    }

}