<?php

namespace Src\Gastos;

use Src\Core\Constants;
use Src\Core\ViewsCore;

class GastosView extends ViewsCore
{

    public function retornar_vista($vista, $modulo, $data=array()) {

        $this->modulo = Constants::MODULO_GASTOS;

        $diccionario_original = $this->diccionario;
        $diccionario_ampliado = array(
            'subtitle'=>array(Constants::VIEW_SET=>'Crear un nuevo gasto',
                Constants::VIEW_GET=>'Buscar gastos',
                Constants::VIEW_DELETE=>'Eliminar un gasto',
                Constants::VIEW_EDIT=>'Modificar un gasto'
            ),
            'form_actions'=>array(
                'SET'=>'../'.Constants::MODULO_GASTOS.Constants::DB_SET.'/',
                'GET'=>'../'.Constants::MODULO_GASTOS.Constants::DB_GET.'/',
                'DELETE'=>'../'.Constants::MODULO_GASTOS.Constants::DB_DELETE.'/',
                'EDIT'=>'../'.Constants::MODULO_GASTOS.Constants::DB_EDIT.'/'
            )
        );
        $this->diccionario = array_merge($diccionario_original, $diccionario_ampliado);

        $html = parent::retornar_vista($vista, $modulo, $data);
        print $html;
    }

}

