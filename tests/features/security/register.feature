@security
Feature: register a new tenant and user

  Background:
    Given I add "CONTENT_TYPE" client header equal to "application/json"
    And I add "HTTP_ACCEPT" client header equal to "application/json"
    And I add "HTTP_AUTHORIZATION" client header equal to " "
    And I add "SCRIPT_FILENAME" client header equal to " "

  Scenario: register a new tenant and user
    When I send a POST request to "/register" with body:
    """
    {
        "email": "theregister@beamscore.com",
        "name": "tenant-test"
    }
    """
    Then the response status code should be 201

  Scenario: register a new tenant and user with invalid email
    When I send a POST request to "/register" with body:
    """
    {
        "email": "theregister",
        "name": "tenant-test"
    }
    """
    Then the response status code should be 400
    And the JSON node "root" should have 1 element
    And the response should have a violation for "email"

  Scenario: register a new tenant and user with none email
    When I send a POST request to "/register" with body:
    """
    {
        "email": "",
        "name": "tenant-test"
    }
    """
    Then the response status code should be 400
    And the JSON node "root" should have 1 element
    And the response should have a violation for "email"

  Scenario: register a new tenant and user with same email as already registered user
    When I send a POST request to "/register" with body:
    """
    {
        "email": "TheTest@beamscore.com",
        "name": "tenant-test"
    }
    """
    Then the response status code should be 400
    And the JSON node "root" should have 1 element
    And the response should have a violation for "email" with "This value is already used."

  Scenario: register a new user and tenant with none name
    When I send a POST request to "/register" with body:
    """
    {
        "email": "theregister@beamscore.com",
        "name": ""
    }
    """
    Then the response status code should be 400
    And the JSON node "root" should have 1 element
    And the response should have a violation for "name"

  Scenario: register a new user and tenant with same name as already existing tenant
    When I send a POST request to "/register" with body:
    """
    {
        "email": "theregister@beamscore.com",
        "name": "First_Tenant"
    }
    """
    Then the response status code should be 400
    And the JSON node "root" should have 1 element
    And the response should have a violation for "name" with "This value is already used."
