<?php

namespace Src\Ingresos;

use Src\Core\Constants;

require_once __DIR__ . '/../../vendor/autoload.php';

$controlador = new IngresosController();
$controlador->handler(Constants::MODULO_INGRESOS);