<?php
namespace Jgalenski\DemoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Jgalenski\DemoBundle\Entity\Article;


class UserData implements FixtureInterface
{
    const ARTICLE_NBR= 10000;

    public function load($manager)
    {
        $this->manager = $manager;
        $this->loadArticle();
    }

    // Create fixtures users
    protected function loadArticle()
    {
        for ($i=1; $i <= self::ARTICLE_NBR ; $i++) { 
            
            $entity = new Article();
            $entity->setTitle('title_' . $i);
            $entity->setContent('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
            $this->manager->persist($entity);
        }
        $this->manager->flush();
    }
}