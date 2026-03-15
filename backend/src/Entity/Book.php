<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArraCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;
    #[ORM\Column(type: "string")]
    private $title;
    #[ORM\Column(type: "string")]
    private $author;
    #[ORM\Column(type: "integer")]
    private $year;
    #[ORM\OneToMany(targetEntity: "Review", mappedBy: "book")]
    private $reviews = [];

    public function __construct( $title, $author, $year)
    {
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function addReview(Review $review)
    {
        $this->reviews[] = $review;
    }

    public function getReviews()
    {
        return $this->reviews;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }
}