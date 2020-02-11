<?php

namespace Src\Gastos;

use Src\Core\Constants;

require_once __DIR__ . '/../../vendor/autoload.php';

$controlador = new GastosController();
$controlador->handler(Constants::MODULO_GASTOS);