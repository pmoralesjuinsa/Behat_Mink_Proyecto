<?php

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use \Behat\Behat\Hook\Scope\AfterStepScope;


/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext implements Context
{

    private $delete_id;


    /**
     * @Then /^(?:|I )save "(ingresos|gastos)" in a local storage device$/
     *
     */
    public function iSaveInALocalStorageDevice($ingreso_gasto)
    {
        $page = $this->getSession()->getPage();

        $content = $page->find('named', array('id', 'listado')); //devuelve el primer elemento que encuentra

        $items = $content->findAll('css',
            'li:not(.titulo)'); //FindAll devuelve todos los elementos que coincidan con li

        $collection = [];

        foreach ($items as $item) {
            $collection[] = $item->getText();
        }

        file_put_contents("scrapped_$ingreso_gasto.txt", join(PHP_EOL, $collection));
    }


    /**
     * @Then I take a screenshot
     * @Then I take a screenshot with :arg1
     */
    public function iTakeAScreenshot($name = '')
    {
        $screenFolder = __DIR__ . '/../../screenshots/';
        $fileName = $name . date('YmdHis');
        $fileExtension = '.png';

        if (!$this->driverSupportsJavascript()) {
            $fileExtension = '.txt';
            file_put_contents(sprintf('%s-%s', $screenFolder, $fileName . $fileExtension), $this->getSession()->getPage()->getOuterHtml());
            return;
        }

        $image_data = $this->getSession()->getDriver()->getScreenshot();
        $file_and_path = $screenFolder . $fileName . '_screenshot' . $fileExtension;
        file_put_contents($file_and_path, $image_data);
    }

    /**
     * * Get the id in form field with specified gasto|ingreso and delete it
     * Example: I delete the desired "ingreso"
     * Example: I delete the desired "gasto"
     *
     * @Then /^(?:|I )delete the desired "(ingreso|gasto)"$/
     */
    public function iDeleteTheDesired($ingreso_gasto)
    {
        $page = $this->getSession()->getPage();
        $content = $page->find('named', array('id', 'alta_usuario'));
        try {
            $delete_id = $content->find('named', array('id', 'id'))->getValue();
        } catch (\Exception $exception) {
            throw new Exception('Desired id not detected');
        }

        $this->getSession()->getPage()->clickLink("Borrar $ingreso_gasto");

        sleep(1);

        $this->iPutTheDesired($delete_id);

    }

    protected function iPutTheDesired($delete_id)
    {
        $this->getSession()->getPage()->fillField("id", $delete_id);
    }

    /**
     * @AfterStep
     * @param AfterStepScope $scope
     */
    public function takeScreenshotAfterFailesStep(AfterStepScope $scope)
    {
        if (99 === $scope->getTestResult()->getResultCode()) {
            $this->iTakeAScreenshot('failStep');
        }
    }

    protected function driverSupportsJavascript()
    {
        $driver = $this->getSession()->getDriver();
        return ($driver instanceof \Behat\Mink\Driver\Selenium2Driver || $driver instanceof \Behat\MinkExtension\ServiceContainer\Driver\SahiFactory);
    }

}
