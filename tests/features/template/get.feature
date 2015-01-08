@template
Feature: Should return a template

  Background:
    Given I have an API Key as placeholder "API_KEY"
    And I add "CONTENT_TYPE" client header equal to "application/json"
    And I add "HTTP_ACCEPT" client header equal to "application/json"
    And I add "HTTP_AUTHORIZATION" client header equal to " "
    And I add "SCRIPT_FILENAME" client header equal to " "

  Scenario: should return valid response for api_key
    When I send a GET request to "/template/first_template?first=test&second=other&apikey=API_KEY" with placeholder
    Then the response status code should be 200
    And the response should contain "test"
    And the response should contain "other"
    And the response should contain "{{third}}"

  Scenario: should not allow calls without api_key
    When I send a GET request to "/template/first_template"
    Then the response status code should be 401

  Scenario: should not allow calls with wrong api_key
    When I send a GET request to "/template/first_template?apikey=wrong"
    Then the response status code should be 401

  Scenario: should get json object for calls with jwt token
    Given I log in as "thetest@beamscore.com" with "test"
    And I set the jwt header
    When I send a GET request to "/template/first_template"
    Then the response status code should be 200
    And the response should be in JSON
    And the JSON should be valid according to the schema "tests/fixtures/json-schema/template.json"
