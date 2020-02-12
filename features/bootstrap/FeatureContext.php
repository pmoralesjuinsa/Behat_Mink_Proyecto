<?php

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;


/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext implements Context
{

    private $delete_id;


    /**
     * @Then I save references in a local storage device
     */
    public function iSaveReferencesInALocalStorageDevice()
    {
        $page = $this->getSession()->getPage();

        $content = $page->find('named', array('id', 'mw-content-text'));

        $references = $content->find('css', '.references'); //Find devuelve únicamente el primer match de la clase .references

        $items = $references->findAll('css', 'li'); //FindAll devuelve todos los elementos que coincidan con li

        $links = [];

        foreach ($items as $item) {
            $linkContainer = $item->find('xpath', '//span[@class="reference-text"]');
            $links[] = $linkContainer->find('xpath', '//a/@href')->getText();
        }

        file_put_contents('scrapped_references.txt', join(PHP_EOL, $links));
    }

    /**
     * @Then I take a screenshot
     * @Then I take a screenshot with :arg1
     */
    public function iTakeAScreenshot($name = '')
    {
        $image_data = $this->getSession()->getDriver()->getScreenshot();
        $file_and_path = __DIR__ . '/../../screenshots/'.$name . strtotime(date('d-m-Y h:i:s')) . '_screenshot.jpg';
        file_put_contents($file_and_path, $image_data);
    }

     /**
     * @Then I delete the desired gasto
     */
    public function iDeleteTheDesiredGasto()
    {
        $page = $this->getSession()->getPage();
        $content = $page->find('named', array('id', 'alta_usuario'));
        try {
            $delete_id = $content->find('named', array('id', 'id'))->getValue();
        } catch (\Exception $exception) {
            throw new Exception('Desired id not detected');
        }

        $this->getSession()->getPage()->clickLink("Borrar gasto");

        sleep(1);

        $this->iPutTheDesiredGasto($delete_id);

    }

    protected function iPutTheDesiredGasto($delete_id)
    {
        $this->getSession()->getPage()->fillField("id", $delete_id);
    }

    /**
     * @Then I delete the desired ingreso
     */
    public function iDeleteTheDesiredIngreso()
    {
        $page = $this->getSession()->getPage();
        $content = $page->find('named', array('id', 'alta_usuario'));
        try {
            $delete_id = $content->find('named', array('id', 'id'))->getValue();
        } catch (\Exception $exception) {
            throw new Exception('Desired id not detected');
        }

        $this->getSession()->getPage()->clickLink("Borrar ingreso");

        sleep(1);

        $this->iPutTheDesiredIngreso($delete_id);

    }

    protected function iPutTheDesiredIngreso($delete_id)
    {
        $this->getSession()->getPage()->fillField("id", $delete_id);
    }
}
