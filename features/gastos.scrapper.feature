Feature: Scrap behat gastos from my localhost project
  In order to practice behat & mink
  As an anonymous user
  I visit my gastos page at localhost


  @gastos_list
  Scenario: See gastos List from dashboard
    Given I am on "http://localhost/dashboard/"
    Then I should see "Beneficios del mes"
    When I follow "Buscar/editar gasto"
    Then the url should match "gastos/buscar"
    And I should see "Listado del mes"

  @edit_gasto
  Scenario: Edit gasto
    Given I am on "http://localhost/gastos/buscar/"
    When I fill in "id" with "44"
    And I press "Buscar"
    And print current URL
    Then I should see "Editar 44"
    Then I fill in "nota" with "Editado con Mink"
    And I press "Guardar"
    Then I should see "Gasto modificado"
#    And I save references in a local storage device

  @add_gasto
  @javascript
  Scenario: Add gasto
    Given I am on "http://localhost/gastos/agregar/"
    And print current URL
    Then I should see "Crear un nuevo gasto"
    When I fill in "id_tipo_gastos" with "9"
    And I fill in "cantidad" with "111"
    And I fill in "importe" with "111"
    And I fill in "fecha" with "2020-02-12"
    And I fill in "nota" with "agregado con Mink"
    Then I take a screenshot
    And I press "Agregar"
    Then I should see "Gasto agregado exitosamente"

