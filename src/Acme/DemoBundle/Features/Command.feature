Feature: Demo greetings command
  In order to show how to describe commands in Behat
  As a Behat developer
  I need to show simple scenario based on http://symfony.com/doc/2.0/components/console.html#testing-commands

  Scenario: Running demo:greet command
    When I run "demo:greet" command
    Then I should see
    """
    Hello

    """

  Scenario: Running demo:greet --yell command
    When I run "demo:greet --yell" command
    Then I should see
    """
    HELLO

    """

  Scenario: Running demo:greet fabien --yell command
    When I run "demo:greet fabien --yell" command
    Then I should see
    """
    HELLO FABIEN

    """