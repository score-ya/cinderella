@template
Feature: Should create a new template

  Background:
    Given I log in as "thetest@beamscore.com" with "test"
    And I add "CONTENT_TYPE" client header equal to "application/json"
    And I add "HTTP_ACCEPT" client header equal to "application/json"
    And I add "SCRIPT_FILENAME" client header equal to " "

  Scenario: should create a new template
    When I send a POST request to "/templates" with body:
    """
    {
      "name" : "Dummy",
      "mimeType": "text/plain",
      "content": "template content",
      "openingVariable": "{{",
      "closingVariable": "}}"
    }
    """
    Then the response status code should be 201
    And the template "Dummy" for "text/plain" should contains:
    """
    template content
    """

  Scenario: should return violations
    When I send a POST request to "/templates" with body:
    """
    {
      "name" : "",
      "mimeType": "text/other",
      "content": "",
      "openingVariable": "",
      "closingVariable": ""
    }
    """
    Then the response status code should be 400
    And the response should have a violation for "name"
    And the response should have a violation for "mimeType"
    And the response should have a violation for "content"
    And the response should have a violation for "openingVariable"
    And the response should have a violation for "closingVariable"

  Scenario: should allow a new template with same name and other mime type
    And I send a POST request to "/templates" with body:
    """
    {
      "name" : "Dummy",
      "mimeType": "text/plain",
      "content": "template content",
      "openingVariable": "{{",
      "closingVariable": "}}"
    }
    """
    And the response status code should be 201
    When I send a POST request to "/templates" with body:
    """
    {
      "name" : "Dummy",
      "mimeType": "text/html",
      "content": "html content",
      "openingVariable": "{{",
      "closingVariable": "}}"
    }
    """
    Then the response status code should be 201
    And the template "Dummy" for "text/html" should contains:
    """
    html content
    """

  Scenario: should not allow a new template with same name and mime type
    And I send a POST request to "/templates" with body:
    """
    {
      "name" : "Dummy",
      "mimeType": "text/plain",
      "content": "template content",
      "openingVariable": "{{",
      "closingVariable": "}}"
    }
    """
    And the response status code should be 201
    When I send a POST request to "/templates" with body:
    """
    {
      "name" : "Dummy",
      "mimeType": "text/plain",
      "content": "html content",
      "openingVariable": "{{",
      "closingVariable": "}}"
    }
    """
    Then the response status code should be 400
    And the response should have a violation for "name"