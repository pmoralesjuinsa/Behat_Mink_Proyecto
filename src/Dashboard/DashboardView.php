<?php

namespace Src\Dashboard;

use Src\Core\Constants;
use Src\Core\ViewsCore;

class DashboardView extends ViewsCore
{

    public function retornar_vista($vista, $modulo, $data=array()) {

        $this->modulo = Constants::MODULO_DASHBOARD;

        $diccionario_original = $this->diccionario;
        $diccionario_ampliado = array(
            'subtitle'=>array(Constants::VIEW_GET=>'Buscar ingresos',
            )
        );
        $this->diccionario = array_merge($diccionario_original, $diccionario_ampliado);

        $html = parent::retornar_vista($vista, $modulo, $data);

        print $html;
    }

}

