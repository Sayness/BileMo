<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Company;

class UserController extends AbstractController
{
    #[Route('/api/users', name: 'api_users_list', methods: ['GET'])]
    public function list(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->createQueryBuilder('u')
            ->leftJoin('u.company', 'c')
            ->addSelect('c')
            ->getQuery()
            ->getResult();
    
        return $this->json($users, Response::HTTP_OK, [], ['groups' => 'user:read']);
    }

    #[Route('/api/users/{id}', name: 'api_users_detail', methods: ['GET'])]
    public function detail(int $id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->createQueryBuilder('u')
            ->leftJoin('u.company', 'c')
            ->addSelect('c')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    
        if (!$user) {
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
    
        return $this->json($user, Response::HTTP_OK, [], ['groups' => 'user:read']);
    }
    
    
    #[Route('/api/users', name: 'create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        // Attente auth donc associe company par défaut
        $company = $entityManager->getRepository(Company::class)->find(1);
    
        if (!$company) {
            return $this->json(['message' => 'Company not found'], Response::HTTP_BAD_REQUEST);
        }
    
        $newUser = new User();
        $newUser->setName($data['name']);
        $newUser->setEmail($data['email']);
        $newUser->setCompany($company);
    
        $entityManager->persist($newUser);
        $entityManager->flush();
    
        return $this->json(['message' => 'User created'], Response::HTTP_CREATED);
    }
    
    

    #[Route('/api/users/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(User $user, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->json(['message' => 'User deleted'], Response::HTTP_OK);
    }
}
