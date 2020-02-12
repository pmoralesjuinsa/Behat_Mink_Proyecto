Feature: Scrap behat dashboard from my localhost project
  In order to practice behat & mink
  As an anonymous user
  I visit my dashboard page at localhost


  @dashboard
  Scenario: See dashboard
    Given I am on "http://localhost/dashboard/"
    Then I should see "Beneficios del mes"