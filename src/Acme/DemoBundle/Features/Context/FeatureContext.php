<?php

namespace Acme\DemoBundle\Features\Context;

use Behat\BehatBundle\Context\BehatContext,
    Behat\BehatBundle\Context\MinkContext;
use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Acme\DemoBundle\Command\GreetCommand;

//
// Require 3rd-party libraries here:
//
  require_once 'PHPUnit/Autoload.php';
  require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends BehatContext //MinkContext if you want to test web
{
    protected $application;
    protected $output;

    public function __construct($kernel)
    {
        $this->application = new Application($kernel);
        $this->application->add(new GreetCommand());
        // add other commands if needed
    }

    /**
     * @When /^I run "([^"]*)" command$/
     */
    public function iRunCommand($cmd_line)
    {
        $input = new StringInput($cmd_line);
        $command = $this->application->find($input->getFirstArgument('command'));
        $input = new StringInput($cmd_line, $command->getDefinition());
        $this->output = new StreamOutput(fopen('php://memory', 'w', false));
        $command->run($input, $this->output);
    }

    /**
     * @Then /^I should see$/
     */
    public function iShouldSee(PyStringNode $string)
    {
        rewind($this->output->getStream());
        $display = stream_get_contents($this->output->getStream());
        assertSame($string->getRaw(), $display);
    }
}
