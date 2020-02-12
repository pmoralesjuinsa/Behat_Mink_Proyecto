Feature: Scrap behat ingresos from my localhost project
  In order to practice behat & mink
  As an anonymous user
  I visit my ingresos page at localhost


  @gastos_list
  Scenario: See gastos List from dashboard
    Given I am on "http://localhost/dashboard/"
    Then I should see "Beneficios del mes"
    When I follow "Buscar/editar ingreso"
    Then the url should match "ingresos/buscar"
    And I should see "Listado del mes"

  @edit_gasto
  Scenario: Edit gasto
    Given I am on "http://localhost/ingresos/buscar/"
    When I fill in "id" with "17"
    And I press "Buscar"
    And print current URL
    Then I should see "Editar 17"
    Then I fill in "importe" with "77500"
    And I press "Guardar"
    Then I should see "Ingreso modificado"
#    And I save references in a local storage device

  @add_gasto
  @javascript
  Scenario: Add gasto
    Given I am on "http://192.168.1.164/ingresos/agregar/"
    And print current URL
    Then I should see "Crear un nuevo ingreso"
    When I fill in "nombre" with "Added with Behat"
    And I fill in "importe" with "80900"
    Then I take a screenshot with "add_ingreso"
    And I press "Agregar"
    Then I should see "Ingreso agregado exitosamente"
    When I follow "Buscar/editar ingreso"
    Then I should see "Buscar ingresos"
    Then I take a screenshot with "add_ingreso"

  @delete_gasto
  @javascript
  Scenario: Delete gasto added by selenium
    Given I am on "http://192.168.1.164/ingresos/buscar/"
    Then I should see "Buscar ingresos"
    When I follow "Added with Behat"
    Then I take a screenshot with "delete_ingreso"
    Then I delete the desired gasto
    Then I take a screenshot with "del_ingreso_id"
    And I press "Eliminar"
    Then I should see "Ingreso eliminado"


