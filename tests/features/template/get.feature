@template
Feature: Should return a template

  Background:
    Given I have an API Key as placeholder "API_KEY"
    And I add "CONTENT_TYPE" client header equal to "application/json"
    And I add "HTTP_ACCEPT" client header equal to "application/json"
    And I add "HTTP_AUTHORIZATION" client header equal to " "
    And I add "SCRIPT_FILENAME" client header equal to " "

  Scenario: should return valid response for api_key
    When I send a GET request to "/template/first-template.txt?first=test&second=other&apikey=API_KEY" with placeholder
    Then the response status code should be 200
    And the response should contain "test"
    And the response should contain "other"
    And the response should contain "{{third}}"

  Scenario: should accept spaces in query values
    When I send a GET request to "/template/first-template.txt?first=test+next&second=other&apikey=API_KEY" with placeholder
    Then the response status code should be 200
    And the response should contain "test next"
    And the response should contain "other"
    And the response should contain "{{third}}"

  Scenario: should update the template variables cache and replace new variables
    Given I log in as "thetest@beamscore.com" with "test"
    # send to init cache
    And I send a GET request to "/template/first-template.txt?first=test+next&second=other&apikey=API_KEY" with placeholder
    And I add "CONTENT_TYPE" client header equal to "application/json"
    And I add "HTTP_ACCEPT" client header equal to "application/json"
    And I add "SCRIPT_FILENAME" client header equal to " "
    And I have a template id as placeholder
    And I send a PUT request to "/templates/TEMPLATE_ID" with placeholder and body:
    """
    {
      "id" : "TEMPLATE_ID",
      "name" : "first_template",
      "mimeType": "text/plain",
      "content": "{{fourth}}"
    }
    """
    And the response status code should be 204
    When I send a GET request to "/template/first-template.txt?first=test+next&second=other&fourth=replace&apikey=API_KEY" with placeholder
    Then the response status code should be 200
    And the response should not contain "test next"
    And the response should not contain "other"
    And the response should not contain "{{third}}"
    And the response should contain "replace"

  Scenario: should not allow calls without api_key
    When I send a GET request to "/template/first-template.txt"
    Then the response status code should be 401

  Scenario: should not allow calls with wrong api_key
    When I send a GET request to "/template/first-template.txt?apikey=wrong"
    Then the response status code should be 401

  Scenario: should return a valid 404 html page for wrong format
    When I send a GET request to "/template/second-template.txt?apikey=API_KEY" with placeholder
    Then the response status code should be 404
    And the header "content-type" should contain "text/html"
    And the header "content-type" should not contain "text/plain"
    And the header "content-type" should not contain "json"

  Scenario: should get json object for calls with jwt token
    Given I log in as "thetest@beamscore.com" with "test"
    And I set the jwt header
    And I have a template id as placeholder
    When I send a GET request to "/templates/TEMPLATE_ID" with placeholder
    Then the response status code should be 200
    And the response should be in JSON
    And the JSON should be valid according to the schema "tests/fixtures/json-schema/template.json"
