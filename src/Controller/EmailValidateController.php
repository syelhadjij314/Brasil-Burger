<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmailValidateController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }
    public function __invoke(EntityManagerInterface $entityManager,Request $request, UserRepository $userRepository)
    {
        $token = $request->get("token");
        $data = $userRepository->findOneBy(["token" => $token]);

        if (!$data) {
            return new JsonResponse(["error" => "token inexistant "], Response::HTTP_BAD_REQUEST);
        }
        if ($data->isIsEnable()) {
            return new JsonResponse(["error" => "Compte activé avec success"], Response::HTTP_BAD_REQUEST);
        }
        if ($data-> getExpireAt()<new \DateTime()) {

            return new JsonResponse(["error" => "token expiré"], Response::HTTP_BAD_REQUEST);
        }
        $data->setIsEnable(true);
        $entityManager->flush();
        return new JsonResponse(["message" => "Compte actif"], Response::HTTP_OK);

    }
}