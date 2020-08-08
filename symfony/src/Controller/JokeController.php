<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/api/jokes", methods={"GET"})
     */
    public function list(JokeRepository $jokeRepo, Request $request)
    {
        $keywords = $request->get('q','');

        $pageNumber = $request->query->getInt('page',1);
        if($pageNumber < 1 || !$pageNumber){
            return $this->sendErrorResponse('Please input a valid number greater than 0 for the page parameter.');
        }

        $pageSize = $request->query->getInt('perPage',$jokeRepo->getMinPerPage());
        if($pageNumber < 1 || !$pageSize || $pageSize > $jokeRepo->getMaxPerPage()){
            return $this->sendErrorResponse('Please input a valid number from 1 and to 100 for the page size parameter.');
        }
        $data = $jokeRepo->findByPage($pageNumber, $pageSize, $keywords);

        return $this->json([
            'status' => 200,
            'jokesPerPage' => $pageSize,
            'totalJokes' => $jokeRepo->getTotal(),
            'pageNumber' => $pageNumber,
            'data' => $data
        ]);
    }

    /**
     * View an individual joke
     * @Route("/api/jokes/search", methods={"GET"})
     */
    public function search(JokeRepository $jokeRepo, Request $request)
    {
        $keywords = $request->get('q','');
        if(!$keywords){
            return $this->sendErrorResponse('Parameter q cannot be empty to search.');
        }
        $data = $jokeRepo->findBySearchTerm($keywords);
        // die($data[0]);
        return $this->json([
            'status' => 200,
            'data' => $data
        ]);
    }



    /**
     * View an individual joke
     * @Route("/api/jokes/{id}", methods={"GET"})
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
     * Handles POST request to create a new Joke.
     * @return JsonResponse
     * @Route("/api/jokes", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $jsonRequest = json_decode($request->getContent(), true);
  
        $newSetup = $jsonRequest['setup'];
        $newPunchline = $jsonRequest['punchline'];
        if (!$newSetup){
            return $this->sendErrorResponse('Setup required for creating a joke.');
        }
        if (!$newPunchline){
            return $this->sendErrorResponse('Punchline required for creating a joke.');
        }
        if(strlen($newSetup) > 225 || strlen($newPunchline) > 225){
            return $this->sendErrorResponse('Character limit of 225.');
        }

    
        $joke = new Joke();
        $joke->setSetup($newSetup);
        $joke->setPunchline($newPunchline);
        $joke->setLaughs(0);
        $entityManager->persist($joke);
        $entityManager->flush();
    
        return $this->json([
            'status' => 200,
            'success' => "Joke added successfully",
        ]);
    
    }

    /**
     * @Route("/api/jokes/{id}", methods={"PATCH"})
     */
    public function update(Joke $joke, Request $request)
    {
        if($joke){
            $entityManager = $this->getDoctrine()->getManager();
            $jsonRequest = json_decode($request->getContent(), true);
  
            $newSetup = isset($jsonRequest['setup']) ? $jsonRequest['setup'] : null;
            if($newSetup !== null){
                if(strlen($newSetup) > 225){
                    return $this->sendErrorResponse('Character limit of 225.');
                }
                $joke->setSetup($newSetup);
        
            }
            $newPunchline = isset($jsonRequest['punchline']) ? $jsonRequest['punchline'] : null;
            if($newPunchline !== null){
                if(strlen($newPunchline) > 225){
                    return $this->sendErrorResponse('Character limit of 225.');
                }
                $joke->setSetup($newPunchline);
            }
            $entityManager->flush();
            $data = [
                'status' => 200,
                'success' => "Joke updated successfully",
            ];
        }
        return $this->sendErrorResponse('Joke not found.');
    }

    /**
     * @Route("/api/jokes/delete/{id}", methods={"DELETE"})
     */
    public function delete(Joke $joke)
    {  
        if($joke){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($joke);
            $entityManager->flush();
            return $this->json([
                'status' => 200,
                'success' => "Joke deleted successfully",
            ]);
        }
    }
}
