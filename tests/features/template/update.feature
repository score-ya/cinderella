@template
Feature: Should update a template

  Background:
    Given I log in as "thetest@beamscore.com" with "test"
    And I add "CONTENT_TYPE" client header equal to "application/json"
    And I add "HTTP_ACCEPT" client header equal to "application/json"
    And I add "SCRIPT_FILENAME" client header equal to " "

  Scenario: should update a template
    Given I have a template id as placeholder
    When I send a PUT request to "/template/TEMPLATE_ID" with placeholder and body:
    """
    {
      "id" : "TEMPLATE_ID",
      "name" : "updated",
      "mimeType": "text/plain",
      "content": "updated template content"
    }
    """
    Then the response status code should be 204
    And the template with id "TEMPLATE_ID" should for "content" contain:
    """
      updated template content
    """
    And the template with id "TEMPLATE_ID" should for "name" contain:
    """
      updated
    """
