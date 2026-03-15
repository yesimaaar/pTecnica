<?php
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArraCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private $id;    
    #[ORM\Column(type: "datetime")]
    private $created_at;
    #[ORM\Column(type: "integer")]
    private $rating;
    #[ORM\Column(type: "string")]
    private $comment;
    #[ORM\ManyToOne(targetEntity: "Book", inversedBy: "reviews")]
    private Book $book;

    public function __construct($id, $book, $rating, $comment)
    {
        if ($rating < 1 || $rating > 5) {
            throw new InvalidArgumentException("La calificación debe estar entre 1 y 5.");
        }

        if (empty($comment)) {
            throw new InvalidArgumentException("El comentario no puede estar vacío.");
        }
        
        $this->id = $id;
        $this->book = $book;
        $this->created_at = new DateTime().format('Y-m-d H:i:s').now();
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

    public function getcreated_at()
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