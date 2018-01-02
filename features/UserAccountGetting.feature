Feature: User account get
  In order to get data about user accounts
  As an API client
  I need to be able to get the data based on their URN

  Background:
    Given the following statuses exist:
      | id | name       |
      | 1  | unverified |
      | 2  | active     |
      | 3  | inactive   |
    And the following website types exist:
      | id | name     |
      | 1  | personal |
      | 2  | github   |
      | 3  | linkedin |
    And the following industries exist:
      | id | name              |
      | 1  | Internet          |
      | 2  | Airlines/Aviation |
    And the following countries exist:
      | code | name           | phone_prefix |
      | DE   | Germany        | 49           |
      | UK   | United Kingdom | 44           |
      | JP   | Japan          | 81           |
      | LU   | Luxembourg     | 352          |
    And the following user accounts are registered:
      | id | status_id | industry_id | first_name | last_name | urn          | date_of_birth | created_at          | updated_at          |
      | 1  | 2         | 1           | Stefan     | Petcu     | stefan-petcu | 1992-03-23    | 2017-10-15 09:51:42 | 2017-10-15 09:55:15 |
      | 2  | 1         | 2           | Foo        | Bar       | foo-bar      | 1992-01-14    | 2017-10-15 09:55:00 | 2017-10-15 09:55:00 |
    And the following emails are registered:
      | id | public_id         | user_account_id | email                    | is_primary | is_verified | created_at          |
      | 1  | JZaMlSqtJSTM44UDu | 1               | stefan.petcu@cveehub.com | 1          | 1           | 2017-10-15 09:51:35 |
      | 2  | MDlU9OZtaXmFZ024z | 1               | contact@stefanpetcu.com  | 0          | 0           | 2017-10-15 09:55:15 |
      | 3  | W4RkEsnK074XmZB4o | 2               | foo.bar@cveehub.com      | 1          | 0           | 2017-10-15 09:55:00 |
    And the following phone numbers are registered:
      | id | public_id         | user_account_id | country_code | number    | is_primary | is_verified | created_at          |
      | 1  | wSE4lwXeYesHavi8F | 1               | LU           | 621526945 | 1          | 0           | 2017-10-15 09:51:37 |
    And the following addresses are registered:
      | id | country_code | postal_code | created_at          |
      | 1  | DE           | 54292       | 2017-10-15 09:51:43 |
    And the following websites are registered:
      | id | public_id         | user_account_id | type_id | url                                     | created_at          | updated_at          |
      | 1  | Vg5qgaeC0lYaEhqpH | 1               | 1       | https://www.stefanpetcu.com             | 2017-10-15 09:51:43 | 2017-10-15 09:51:43 |
      | 2  | 5S24Ws33qtngtyGPD | 1               | 2       | https://www.github.com/stevepetcu       | 2017-10-15 09:51:47 | 2017-10-15 09:51:47 |
      | 3  | UdQrA1AzuZajbiGWP | 1               | 3       | https://www.linkedin.com/in/stefanpetcu | 2017-10-15 09:51:51 | 2017-10-15 09:51:51 |

  Scenario: Get my user account data
    When I request "/users/stefan-petcu"
    Then the response status line is "200 OK"
    And the response body contains JSON:
      """
        {
          "first_name": "Stefan",
          "last_name": "Petcu",
          "industry": "Internet",
          "urn": "stefan-petcu",
          "status": "active",
          "date_of_birth": "1992-03-23",
          "emails": [
            {
              "id": "JZaMlSqtJSTM44UDu",
              "email": "stefan.petcu@cveehub.com",
              "primary": true,
              "verified": true
            },
            {
              "id": "MDlU9OZtaXmFZ024z",
              "email": "contact@stefanpetcu.com",
              "primary": false,
              "verified": false
            }
          ],
          "phone_numbers": [
            {
              "id": "wSE4lwXeYesHavi8F",
              "number": "621526945",
              "country": {
                "name": "Luxembourg",
                "code": "LU",
                "phone_prefix": "352"
              },
              "primary": true,
              "verified": false
            }
          ],
          "websites": [
            {
              "id": "Vg5qgaeC0lYaEhqpH",
              "url": "https://www.stefanpetcu.com",
              "type": "personal"
            },
            {
              "id": "5S24Ws33qtngtyGPD",
              "url": "https://www.github.com/stevepetcu",
              "type": "github"
            },
            {
              "id": "UdQrA1AzuZajbiGWP",
              "url": "https://www.linkedin.com/in/stefanpetcu",
              "type": "linkedin"
            }
          ],
          "address": {
            "country": {
                "name": "Germany",
                "code": "DE",
                "phone_prefix": "49"
            },
            "postal_code": "54292"
          },
          "created_at": "2017-10-15 09:51:42",
          "updated_at": "2017-10-15 09:55:15"
        }
      """

  Scenario: Try to get an inexistent user
    When I request "/users/not-registered-user"
    Then the response status line is "404 Resource not found."
    And the response body contains JSON:
      """
      {
        "error": {
            "code": 404,
            "message": "User with unique link 'not-registered-user' does not exist."
        }
      }
      """

  Scenario: Try to get an unacceptable response format
    Given the "Accept" request header is "text/xml"
    When I request "/users/not-registered-user"
    Then the response status line is "406 Requested media type not available. Must be one of: application/json."
    And the response body contains JSON:
      """
      {
        "error": {
            "code": 406,
            "message": "Requested media type not available. Must be one of: application/json."
        }
      }
      """

  Scenario: Send unacceptable characters in the user URN
    When I request "/users/foo-b@r"
    Then the response status line is "404 Page not found."
    And the response body contains JSON:
      """
      {
        "error": {
            "code": 404,
            "message": "Page not found."
        }
      }
      """