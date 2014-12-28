@template
Feature: Should get a template for an api key

  Background:
    Given I have an API Key as placeholder "API_KEY"

  Scenario: should return valid response for api_key
    Given I add "CONTENT_TYPE" client header equal to "application/json"
    And I add "HTTP_ACCEPT" client header equal to "application/json"
    And I add "HTTP_AUTHORIZATION" client header equal to " "
    And I add "SCRIPT_FILENAME" client header equal to " "
    When I send a GET request to "/template/first_template?apikey=API_KEY" with placeholder
    Then the response status code should be 200

  Scenario: should not allow calls without api_key
    Given I add "CONTENT_TYPE" client header equal to "application/json"
    And I add "HTTP_ACCEPT" client header equal to "application/json"
    And I add "HTTP_AUTHORIZATION" client header equal to " "
    And I add "SCRIPT_FILENAME" client header equal to " "
    When I send a GET request to "/template/first_template"
    Then the response status code should be 401

  Scenario: should not allow calls with wrong api_key
    Given I add "CONTENT_TYPE" client header equal to "application/json"
    And I add "HTTP_ACCEPT" client header equal to "application/json"
    And I add "HTTP_AUTHORIZATION" client header equal to " "
    And I add "SCRIPT_FILENAME" client header equal to " "
    When I send a GET request to "/template/first_template?apikey=wrong"
    Then the response status code should be 401

  Scenario: should not allow calls with jwt token
    Given I log in as "thetest@beamscore.com" with "test"
    And I set the jwt header
    And I add "SCRIPT_FILENAME" client header equal to " "
    When I send a GET request to "/template/first_template"
    Then the response status code should be 401
