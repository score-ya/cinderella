@user
Feature: Create an api key for the tenant of the current user

  Background:
    Given I log in as "thetest@beamscore.com" with "test"
    And I add "CONTENT_TYPE" client header equal to "application/json"
    And I add "HTTP_ACCEPT" client header equal to "application/json"
    And I add "SCRIPT_FILENAME" client header equal to " "

  Scenario: should not allow creation for invalid authorization
    Given I add "HTTP_AUTHORIZATION" client header equal to " "
    When I send a POST request to "/users/create-api-key"
    Then the response status code should be 401

  Scenario: should create an api key
    When I send a POST request to "/users/create-api-key"
    Then the response status code should be 201
    And the tenant "first_tenant" should have an api key

  Scenario: should create only one api key user
    Given I send a POST request to "/users/create-api-key"
    And the response status code should be 201
    And the tenant "first_tenant" should have an api key
    When I send a POST request to "/users/create-api-key"
    Then the response status code should be 409
