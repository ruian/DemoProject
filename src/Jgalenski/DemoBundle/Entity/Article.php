<?php
namespace Jgalenski\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * Jgalenski\DemoBundle\Entity\Article
 * @ORM\Entity(repositoryClass="Jgalenski\DemoBundle\Entity\Repository\ArticleRepository")
 * @ORM\Table(name="tumblr_jgalenski_article")
 * @ORM\HasLifecycleCallbacks
 * @author jgalenski
 */
class Article
{
    
    /**
     * @var integer $id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\MaxLength(limit=255, message="Title: You exceed the {{limit}} charactere limit")
     */
    protected $title;

    /**
     * @ORM\Column(type="text", length=4000)
     * @Assert\MaxLength(limit=4000, message="Content: You exceed the {{limit}} charactere limit")
     */
    protected $content;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    function __construct()
    {
        $this->created_at = new DateTime();
    }

    /** 
     * @return void
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /** 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /** 
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * @param string $content
     * @return void
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
}