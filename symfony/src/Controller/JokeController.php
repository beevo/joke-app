<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\ParameterBag;

use App\Entity\Joke;
use App\Repository\JokeRepository;

class JokeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function ui()
    {
        return $this->render('index.html');
    }

    /**
     * Will return a JsonResponse for error handling after failed validation
     * @return JsonResponse
     * 
     */
    public function sendErrorResponse($message){
        return $this->json([
            'error' => $message
        ], 400);
    }

    /**
     * @return JsonResponse
     * @Route("/api/jokes")
     * 
     */
    public function list(JokeRepository $jokeRepo, Request $request)
    {
        $pageNumber = $request->query->getInt('page',1);
        if($pageNumber < 1 || !$pageNumber){
            return $this->sendErrorResponse('Please input a valid number greater than 0 for the page parameter.');
        }

        $pageSize = $request->query->getInt('pageSize',$jokeRepo->getMinPerPage());
        if($pageNumber < 1 || !$pageSize || $pageSize > $jokeRepo->getMaxPerPage()){
            return $this->sendErrorResponse('Please input a valid number from 1 and to 100 for the page size parameter.');
        }
        $data = $jokeRepo->findByPage($pageNumber, $pageSize);

        return $this->json([
            'jokesPerPage' => $pageSize,
            'totalJokes' => $jokeRepo->getTotal(),
            'pageNumber' => $pageNumber,
            'data' => $data
        ]);
    }

    /**
     * View an individual joke
     * @Route("/api/jokes/{id}")
     */
    public function view(Joke $joke)
    {
        // $repo = $this->getDoctrine()->getRepository(Joke::class);
        // $joke = $repo->find($id);
        if($joke){
            return $this->json([
                'setup' => $joke->getSetup(),
                'punchline' => $joke->getPunchline(),
                'laughs' => $joke->getLaughs(),
            ]);
        }
        return $this->json([
            'message' => 'View a joke',
            'data' => $_GET
        ]);
    }

    /**
     * @Route("/api/jokes/create")
     */
    public function create()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $joke = new Joke();
        $joke->setSetup('Foo');
        $joke->setPunchline('Bar');
        $joke->setLaughs(0);

        $entityManager->persist($joke);
        $entityManager->flush();

        return $this->json([
            'message' => 'Create Joke'
        ]);
    }

    /**
     * @Route("/api/jokes/update/{id}")
     */
    public function update(Joke $joke)
    {
        if($joke){
            $entityManager = $this->getDoctrine()->getManager();
            $joke->setSetup("New Setup");
            $entityManager->flush();
            return $this->json([
                'setup' => $joke->getSetup(),
                'punchline' => $joke->getPunchline(),
                'laughs' => $joke->getLaughs(),
            ]);
        }
        return $this->json([
            'message' => 'Update Joke'
        ]);
    }

    /**
     * @Route("/api/jokes/delete/{id}")
     */
    public function delete(Joke $joke)
    {
        if($joke){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($joke);
            $entityManager->flush();
            return $this->json([
                'success' => true
            ]);
        }
        return $this->json([
            'message' => 'Delete Joke'
        ]);
    }
}
