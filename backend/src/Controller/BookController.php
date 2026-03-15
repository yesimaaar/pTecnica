<?php
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class BookController extends AbstractController
{

    #[Route('/api/books', name: 'book_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em) : JSONResponse
    {
        $data = json_decode($request->getContent(), true);

        $book = new Book();
        $book->setTitle($data['title']);
        $book->setAuthor($data['author']);
        $book->setPublishedDate(new \DateTime($data['publishedDate']));

        $em->persist($book);
        $em->flush();

        return new Response('Book created successfully', Response::HTTP_CREATED);
    }

    #[Route('/api/books', name: 'book_list', methods: ['GET'])]
    public function list(EntityManagerInterface $em): JsonResponse
    {
        $repository = $em->getRepository(Book::class);
        $books = $repository->findAll(); // Lanza un "SELECT * FROM book"

        return $this->json($books);
    }
}