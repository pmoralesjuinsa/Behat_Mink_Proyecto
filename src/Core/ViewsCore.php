<?php


namespace Src\Core;


class ViewsCore
{
    protected $diccionario = array(
        'links_menu'=>array(
            'VIEW_DASHBOARD'=>Constants::MODULO_DASHBOARD.Constants::VIEW_GET.'/',
            'VIEW_SET_GASTOS'=>Constants::MODULO_GASTOS.Constants::VIEW_SET.'/',
            'VIEW_GET_GASTOS'=>Constants::MODULO_GASTOS.Constants::VIEW_GET.'/',
            'VIEW_EDIT_GASTOS'=>Constants::MODULO_GASTOS.Constants::VIEW_EDIT.'/',
            'VIEW_DELETE_GASTOS'=>Constants::MODULO_GASTOS.Constants::VIEW_DELETE.'/',
            'VIEW_DELETE_INGRESOS'=>Constants::MODULO_INGRESOS.Constants::VIEW_DELETE.'/',
            'VIEW_EDIT_INGRESOS'=>Constants::MODULO_INGRESOS.Constants::VIEW_EDIT.'/',
            'VIEW_GET_INGRESOS'=>Constants::MODULO_INGRESOS.Constants::VIEW_GET.'/',
            'VIEW_SET_INGRESOS'=>Constants::MODULO_INGRESOS.Constants::VIEW_SET.'/',
        ),
        'form_actions' => array(),
        'subtitle' => array()
    );
    protected $modulo;

    public function get_template($form='get', $modulo) {
        $file = __DIR__ . '/../../site_media/html/'.$modulo.'/'.$form.'.html';
        $template = file_get_contents($file);
        return $template;
    }

    public function render_dinamic_data($html, $data) {

        foreach ($data as $clave=>$valor) {
            if($clave == 'lista') {
                $html = $this->render_list($html, $data);
            } else {
                $html = str_replace('{'.$clave.'}', $valor, $html);
            }

        }
        return $html;
    }

    public function render_list($html = "", $data_list = array()) {
        $total = 0;
        $html_list = "";
        $html_fichero = $this->get_template('list', $this->modulo);

        foreach($data_list['lista'] as $key=>$valores) {

            $total_linea = (int)$valores['cantidad'] * (float)$valores['importe'];
            $valores['total_linea'] = $total_linea;

            $total = $this->getTotalLine($valores, $total);

            if(isset($valores['fecha'])) {
                $valores['fecha'] = date("d-m-Y H:i:s",strtotime($valores['fecha']));
            }

            $html_list .= $this->render_dinamic_data($html_fichero, $valores);
        }

        $html = str_replace('{lista}', $html_list, $html);
        $html = str_replace('{total}', $total, $html);

        return $html;
    }

    public function retornar_vista($vista, $modulo, $data=array()) {

        $html = $this->buildTemplate();
        $html = str_replace('{subtitulo}', $this->diccionario['subtitle'][$vista], $html);
        $html = str_replace('{formulario}', $this->get_template($vista, $modulo), $html);
        $html = $this->putAllDynamicData($html, $data);
        $html = $this->putMensajeTemplate($html, $data, $vista);

        return $html;
    }

    public function putMensajeTemplate($html, $data, $vista)
    {
        if(array_key_exists('id', $data) &&
            $vista==Constants::VIEW_EDIT) {
            $mensaje = 'Editar '.$data['id'];
        } else {
            if(array_key_exists('mensaje', $data)) {
                $mensaje = $data['mensaje'];
            } else {
                $mensaje = 'Datos ampliados:';
            }
        }

        $html = str_replace('{mensaje}', $mensaje, $html);

        return $html;
    }

    public function buildTemplate()
    {
        $html = $this->get_template('header', "core");
        $html .= $this->get_template('template', "core");
        $html .= $this->get_template('footer', "core");

        return $html;
    }

    public function putAllDynamicData($html, $data)
    {
        $html = $this->render_dinamic_data($html, $data);
        $html = $this->render_dinamic_data($html, $this->diccionario['form_actions']);
        $html = $this->render_dinamic_data($html, $this->diccionario['links_menu']);

        return $html;
    }

    /**
     * @param $valores
     * @param $total
     * @return array
     */
    public function getTotalLine($valores, $total)
    {
        if (isset($valores['cantidad'])) {
            $total = $total + $valores['cantidad'] * $valores['importe'];
        } else {
            $total = $total + $valores['importe'];
        }

        return $total;
    }

}