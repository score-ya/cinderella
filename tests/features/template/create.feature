@template
Feature: Should create a new template

  Background:
    Given I log in as "thetest@beamscore.com" with "test"
    And I add "CONTENT_TYPE" client header equal to "application/json"
    And I add "HTTP_ACCEPT" client header equal to "application/json"
    And I add "SCRIPT_FILENAME" client header equal to " "

  Scenario: should return valid response for api_key
    When I send a POST request to "/template" with body:
    """
    {
      "name" : "Dummy",
      "mimeType": "text/plain",
      "content": "template content"
    }
    """
    Then the response status code should be 201
    And the template "Dummy" should contains:
    """
    template content
    """

  Scenario: should return violations
    When I send a POST request to "/template" with body:
    """
    {
      "name" : "",
      "mimeType": "text/other",
      "content": ""
    }
    """
    Then the response status code should be 400
    And the response should have a violation for "name"
    And the response should have a violation for "mimeType"
    And the response should have a violation for "content"