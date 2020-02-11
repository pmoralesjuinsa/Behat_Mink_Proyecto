<?php

namespace Src\Ingresos;

use Src\Core\Constants;
use Src\Core\ViewsCore;

class IngresosView extends ViewsCore
{

    public function retornar_vista($vista, $modulo, $data=array()) {

        $this->modulo = Constants::MODULO_INGRESOS;

        $diccionario_original = $this->diccionario;
        $diccionario_ampliado = array(
            'subtitle'=>array(Constants::VIEW_SET=>'Crear un nuevo ingreso',
                Constants::VIEW_GET=>'Buscar ingresos',
                Constants::VIEW_DELETE=>'Eliminar un ingreso',
                Constants::VIEW_EDIT=>'Modificar un ingreso'
            ),
            'form_actions'=>array(
                'SET'=>'../'.Constants::MODULO_INGRESOS.Constants::DB_SET.'/',
                'GET'=>'../'.Constants::MODULO_INGRESOS.Constants::DB_GET.'/',
                'DELETE'=>'../'.Constants::MODULO_INGRESOS.Constants::DB_DELETE.'/',
                'EDIT'=>'../'.Constants::MODULO_INGRESOS.Constants::DB_EDIT.'/'
            )
        );
        $this->diccionario = array_merge($diccionario_original, $diccionario_ampliado);

        $html = parent::retornar_vista($vista, $modulo, $data);
        print $html;
    }

}

