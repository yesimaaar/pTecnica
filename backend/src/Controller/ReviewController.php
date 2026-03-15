<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Review;
use App\Entity\Book;

class ReviewController extends AbstractController
{
    #[Route('/api/reviews', name: 'api_reviews_get', methods: ['GET'])]
    public function getReviews(): JsonResponse
    {
        $reviews = $this->getDoctrine()->getRepository(Review::class)->findAll();
        return $this->json($reviews);
    }

    #[Route('/api/reviews', name: 'api_reviews_post', methods: ['POST'])]
    public function createReview(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['book_id'], $data['rating'], $data['comment'])) {
            return $this->json(['error' => 'Missing required fields'], 400);
        }

        $book = $this->getDoctrine()->getRepository(Book::class)->find($data['book_id']);
        if (!$book) {
            return $this->json(['error' => 'Book not found'], 404);
        }

        try {
            $review = new Review($book, $data['rating'], $data['comment']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();
            return $this->json($review, 201);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }

}