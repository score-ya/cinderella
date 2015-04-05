@security
Feature: confirm a new user

  Background:
    Given I add "CONTENT_TYPE" client header equal to "application/json"
    And I add "HTTP_ACCEPT" client header equal to "application/json"
    And I add "HTTP_AUTHORIZATION" client header equal to " "
    And I add "SCRIPT_FILENAME" client header equal to " "

  Scenario: confirm a new user with valid user
    When I send a PATCH request to "/confirm/EqdfjDCfGTWEu-EM5KxJcSPaUEk4_XmGq5Q0B4oEuMY"
    Then the response status code should be 204
    When I send a POST request to "/login" with body:
    """
    {
        "email": "confirm@beamscore.com",
        "password": "test"
    }
    """
    Then the response status code should be 200
    And the jwt should have a "username" field with "confirm@beamscore.com"

  Scenario: try to confirm with same key again
    Given I send a PATCH request to "/confirm/EqdfjDCfGTWEu-EM5KxJcSPaUEk4_XmGq5Q0B4oEuMY"
    And the response status code should be 204
    When I send a PATCH request to "/confirm/EqdfjDCfGTWEu-EM5KxJcSPaUEk4_XmGq5Q0B4oEuMY"
    Then the response status code should be 404

  Scenario: try to confirm with invalid key
    When I send a PATCH request to "/confirm/other"
    Then the response status code should be 404
