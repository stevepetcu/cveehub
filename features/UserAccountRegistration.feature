Feature: User account registration
  In order to manage my resumes
  As a candidate
  I need to create a user account

  Background:
    Given the following industries exist:
      | id | name     |
      | 1  | internet |

  Scenario: Register a new user account
    Given the following form parameters are set:
      | name         | value                    |
      | first_name   | Stefan                   |
      | last_name    | Petcu                    |
      | email        | stefan.petcu@cveehub.com |
      | country_code | GB                       |
      | postal_code  | SW9 6FY                  |
      | industry_id  | 1                        |
    When I request "/users" using HTTP POST
    Then the response status line is "201 Created"
    And the "Location" response header is "/stefan-petcu"

    #TODO:!!! The dates matching must be partial...!!!

    #TODO: Test email for email address verification.
    #TODO: Test sms for phone number verification.

    #TODO: Review all the stuff below.

#  Scenario: Register a new user account when a user with the same first name and last name already exists
#    Given the following users are registered:
#      | id | first_name | last_name |
#      | 1  | Stefan     | Petcu     |
#    And the following emails are registered:
#      | id | user_id | email                    |
#      | 1  | 1       | stefan.petcu@cveehub.com |
#    And the following form parameters are set:
#      | name       | value               |
#      | first_name | Stefan              |
#      | last_name  | Petcu               |
#      | email      | foo.bar@cveehub.com |
#      | password   | Test12345!          |
#    When I request "/users" using HTTP POST
#    Then the response status line is "201 Created"
#    And the "Location" response header matches "/stefan-petcu-[a-zA-Z1-9]{7}/"
#
#  Scenario: Send incomplete user account registration data
#    Given the following form parameters are set:
#      | name       | value |
#      | first_name |       |
#      | last_name  |       |
#      | email      |       |
#    When I request "/users" using HTTP POST
#    Then the response status line is "400 Bad Request"
#    And the response body matches:
#      """
#        The following parameters cannot be empty: first_name, last_name, email.
#      """
#
#  Scenario: Send already existing email in the registration data
#    Given the following users are registered:
#      | id | first_name | last_name |
#      | 1  | Stefan     | Petcu     |
#    And the following emails are registered:
#      | id | user_id | email                    |
#      | 1  | 1       | stefan.petcu@cveehub.com |
#    And the following form parameters are set:
#      | name       | value                    |
#      | first_name | Stefan                   |
#      | last_name  | Petcu                    |
#      | email      | stefan.petcu@cveehub.com |
#      | password   | Test12345!               |
#    When I request "/users" using HTTP POST
#    Then the response status line is "409 Conflict"
#    And the response body matches:
#      """
#        "The specified email address is already registered."
#      """
#
#  Scenario: Send invalid email in the registration data
#  Given the following form parameters are set:
#    | name       | value      |
#    | first_name | Stefan     |
#    | last_name  | Petcu      |
#    | email      | invalid    |
#    | password   | Test12345! |
#  When I request "/users" using HTTP POST
#  Then the response status line is "422 Unprocessable Entity"
#  And the response body matches:
#      """
#        The provided email address is not valid.
#      """
#
#  Scenario: Send weak password in the registration data
#    Given the following form parameters are set:
#      | name       | value                    |
#      | first_name | Stefan                   |
#      | last_name  | Petcu                    |
#      | email      | stefan.petcu@cveehub.com |
#      | password   | 123                      |
#    When I request "/users" using HTTP POST
#    Then the response status line is "422 Unprocessable Entity"
#    And the response body matches:
#      """
#        The provided password is too simple. Please use a password that is at least 10 characters long.
#      """