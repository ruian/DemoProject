<?php

namespace Jgalenski\DemoBundle\Features\Context;

use Behat\BehatBundle\Context\BehatContext,
    Behat\BehatBundle\Context\MinkContext;
use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Jgalenski\DemoBundle\Entity\Article;
use Doctrine\ORM\Query;
//
// Require 3rd-party libraries here:
//
  require_once 'PHPUnit/Autoload.php';
  require_once 'PHPUnit/Framework/Assert/Functions.php';


/**
 * Feature context.
 */
class FeatureContext extends MinkContext
{
//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        $container = $this->getContainer();
//        $container->get('some_service')->doSomethingWith($argument);
//    }
//

    protected $query;

    /**
     * @Given /^There is no "([^"]*)" in database$/
     */
    public function thereIsNoInDatabase($entityName)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine.orm.default_entity_manager');

        $entities = $em->getRepository('JgalenskiDemoBundle:' . $entityName)->findAll();
        foreach ($entities as $eachEntity) {
            $em->remove($eachEntity);
        }

        $em->flush();
    }

    /**
     * @Given /^I create (\d+) random Article entries$/
     */
    public function iCreateRandomArticleEntries($nbr)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine.orm.default_entity_manager');

        for ($i=0; $i < $nbr; $i++) { 
            $entity = new Article();
            $entity->setTitle('title' . $i);
            $entity->setContent('content' . $i);

            $em->persist($entity);
        }

        $em->flush();
    }

    /**
     * @When /^I want to get all articles$/
     */
    public function iWantToGetAllArticles()
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('JgalenskiDemoBundle:Article');

        $this->query = $repo->queryFindAll();
    }

    /**
     * @Then /^I should get a Query object$/
     */
    public function iShouldGetAQueryObject()
    {
        assertTrue($this->query instanceof Query);
        $this->query = null;
    }

    /**
     * @When /^I want to get article with some random criteria$/
     */
    public function iWantToGetArticleWithSomeRandomCriteria()
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('JgalenskiDemoBundle:Article');

        $this->query = $repo->queryFindBy(array('id' => 1), array('created_at' => 'DESC'));
    }

    /**
     * @When /^I want to get one article$/
     */
    public function iWantToGetOneArticle()
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('JgalenskiDemoBundle:Article');

        $this->query = $repo->queryFindOneBy(array('id' => 1));
    }


}
