<?php


namespace Src\Core;


class ParamsDTO
{
    protected $modelView;
    protected $model;
    protected $userData;
    protected $myNamespace;
    protected $modulo;

    function __construct(Array $params)
    {
        $this->modelView = $params['modelView'];
        $this->model = $params['model'];
        $this->userData = $params['userData'];
        $this->myNamespace = $params['myNamespace'];
        $this->modulo = $params['modulo'];
    }

    public function getModelView()
    {
        return $this->modelView;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getUserData()
    {
        return $this->userData;
    }

    public function getMyNamespace()
    {
        return $this->myNamespace;
    }

    public function getModulo()
    {
        return $this->modulo;
    }

}