<?php
namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/api/books', name: 'book_list', methods: ['GET'])]
    public function list(EntityManagerInterface $em): JsonResponse
    {
        // Consulta DQL para obtener libros con el promedio de sus reseñas
        $books = $em->createQueryBuilder()
            ->select('b.id', 'b.title', 'b.author', 'b.year as published_year')
            ->addSelect('AVG(r.rating) as average_rating')
            ->from(Book::class, 'b')
            ->leftJoin('b.reviews', 'r')
            ->groupBy('b.id')
            ->getQuery()
            ->getResult();

        // Formateamos el promedio a 1 decimal
        foreach ($books as &$book) {
            $book['average_rating'] = $book['average_rating'] ? round($book['average_rating'], 1) : 0;
        }

        return $this->json($books);
    }
}