<?php


namespace Src\Dashboard;


use Src\Core\Constants;
use Src\Gastos\GastosListModel;
use Src\Ingresos\IngresosListModel;

class DashboardController
{
    function handler()
    {
        $dashboardView = new DashboardView();

        $data = array(
            'total_beneficios' => $this->getDifferenceBetweenIngresosGastos(),
        );
        $data['mensaje'] = "Beneficios del mes";
        print $dashboardView->retornar_vista(Constants::VIEW_GET, Constants::MODULO_DASHBOARD, $data);

    }

    function getDifferenceBetweenIngresosGastos()
    {
        $gastos = new GastosListModel();
        $ingresos = new IngresosListModel();

        $gastos->get();
        $ingresos->get();

        $total_gastos = 0;
        $total_ingresos = 0;

        foreach ($gastos->gastos_list as $gasto) {
            $total_gastos = $total_gastos + $gasto['cantidad'] * $gasto['importe'];
        }

        foreach ($ingresos->ingresos_list as $ingreso) {
            $total_ingresos = $total_ingresos + $ingreso['importe'];
        }

        return (float)$total_ingresos - (float)$total_gastos;
    }
}