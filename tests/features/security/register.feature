@security
Feature: register a new user

  Background:
    Given I add "CONTENT_TYPE" client header equal to "application/json"
    And I add "HTTP_ACCEPT" client header equal to "application/json"
    And I add "HTTP_AUTHORIZATION" client header equal to " "
    And I add "SCRIPT_FILENAME" client header equal to " "

  Scenario: register a new user
    Given the template client send a request for "user_created.txt" with:
    """
    txt user_created content
    """
    And the template client send a request for "user_created.html" with:
    """
    html user_created content
    """
    When I send a POST request to "/register" with body:
    """
    {
        "email": "theregister@beamscore.com",
        "plainPassword": "password",
        "repeatedPlainPassword": "password"
    }
    """
    Then the response status code should be 201
    And I should receive an email on "theregister@beamscore.com" with:
    """
html user_created content
    """

  Scenario: register a new user with invalid password
    When I send a POST request to "/register" with body:
    """
    {
        "email": "theregister@beamscore.com",
        "plainPassword": "3",
        "repeatedPlainPassword": "password"
    }
    """
    Then the response status code should be 400
    And the JSON node "root" should have 1 element
    And the response should have a violation for "plainPassword"

  Scenario: register a new user with invalid email
    When I send a POST request to "/register" with body:
    """
    {
        "email": "theregister",
        "plainPassword": "password",
        "repeatedPlainPassword": "password"
    }
    """
    Then the response status code should be 400
    And the JSON node "root" should have 1 element
    And the response should have a violation for "email"

  Scenario: register a new user with none email
    When I send a POST request to "/register" with body:
    """
    {
        "email": "",
        "plainPassword": "password",
        "repeatedPlainPassword": "password"
    }
    """
    Then the response status code should be 400
    And the JSON node "root" should have 1 element
    And the response should have a violation for "email"

  Scenario: register a new user with same email as already registered user
    When I send a POST request to "/register" with body:
    """
    {
        "email": "TheTest@beamscore.com",
        "plainPassword": "password",
        "repeatedPlainPassword": "password"
    }
    """
    Then the response status code should be 400
    And the JSON node "root" should have 1 element
    And the response should have a violation for "email" with "This value is already used."