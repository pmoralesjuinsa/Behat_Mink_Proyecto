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
    When I fill in "id" with "11"
    And I press "Buscar"
    And print current URL
    Then I should see "Editar 11"
#    And I save references in a local storage device

#  @primeros_pasos
#  @javascript
#  Scenario: Navigating Wikipedia Spain "Primeros pasos"
#    And print current URL
#    Then I should see "Bienvenidos"
#    Then the url should match "wiki/Wikipedia:Portada"
#    When I follow "Primeros pasos"
#    Then I should see "Introducción a Wikipedia"
#    When I follow "Imágenes"
#    And print current URL
#    Then I take a screenshot