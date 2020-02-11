<?php

namespace Src\Core;

class Constants
{
    #model
    const MODULO_GASTOS = "gastos/";
    const MODULO_INGRESOS = "ingresos/";
    const MODULO_DASHBOARD = "dashboard/";

    # controladores
    const DB_SET = 'set';
    const DB_GET = 'get';
    const DB_DELETE = 'delete';
    const DB_EDIT = 'edit';

    # vistas
    const VIEW_SET = 'agregar';
    const VIEW_GET = 'buscar';
    const VIEW_DELETE = 'borrar';
    const VIEW_EDIT = 'modificar';
}