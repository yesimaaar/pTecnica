<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use DateTime;
use InvalidArgumentException;

#[ORM\Entity]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;
    #[ORM\Column(type: "datetime")]
    private $created_at;
    #[ORM\Column(type: "integer")]
    private $rating;
    #[ORM\Column(type: "string")]
    private $comment;
    #[ORM\ManyToOne(targetEntity: "Book", inversedBy: "reviews")]
    private Book $book;

    public function __construct(Book $book, int $rating, string $comment)
    {
        if ($rating < 1 || $rating > 5) {
            throw new InvalidArgumentException("La calificación debe estar entre 1 y 5.");
        }

        if (empty($comment)) {
            throw new InvalidArgumentException("El comentario no puede estar vacío.");
        }

        $this->book = $book;
        $this->created_at = new DateTime();
        $this->rating = $rating;
        $this->comment = $comment;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getBookId()
    {
        return $this->book->getId();
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function getComment()
    {
        return $this->comment;
    }
}