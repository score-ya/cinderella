@template
Feature: Should delete a template

  Background:
    Given I log in as "thetest@beamscore.com" with "test"
    And I add "CONTENT_TYPE" client header equal to "application/json"
    And I add "HTTP_ACCEPT" client header equal to "application/json"
    And I add "SCRIPT_FILENAME" client header equal to " "

  Scenario: should delete a template
    Given I have a template id as placeholder
    When I send a DELETE request to "/template/TEMPLATE_ID" with placeholder
    Then the response status code should be 204
    And I send a GET request to "/template/TEMPLATE_ID" with placeholder
    Then the response status code should be 404