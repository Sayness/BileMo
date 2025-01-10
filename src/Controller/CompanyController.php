<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    #[Route('/api/companies', name: 'api_companies_list', methods: ['GET'])]
    public function list(CompanyRepository $companyRepository): JsonResponse
    {
        $companies = $companyRepository->findAll();

        $data = array_map(function (Company $company) {
            return [
                'id' => $company->getId(),
                'name' => $company->getName(),
                'email' => $company->getEmail(),
            ];
        }, $companies);

        return $this->json($data, Response::HTTP_OK);
    }

    #[Route('/api/companies/{id}', name: 'api_companies_show', methods: ['GET'])]
    public function show(Company $company): JsonResponse
    {
        $data = [
            'id' => $company->getId(),
            'name' => $company->getName(),
            'email' => $company->getEmail(),
        ];

        return $this->json($data, Response::HTTP_OK);
    }

    #[Route('/api/companies', name: 'api_companies_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $company = new Company();
        $company->setName($data['name']);
        $company->setEmail($data['email']);
        $company->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));

        $entityManager->persist($company);
        $entityManager->flush();

        return $this->json(['message' => 'Company created successfully.'], Response::HTTP_CREATED);
    }

    #[Route('/api/companies/{id}', name: 'api_companies_update', methods: ['PUT'])]
    public function update(Company $company, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $company->setName($data['name'] ?? $company->getName());
        $company->setEmail($data['email'] ?? $company->getEmail());
        if (isset($data['password'])) {
            $company->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
        }

        $entityManager->flush();

        return $this->json(['message' => 'Company updated successfully.'], Response::HTTP_OK);
    }

    #[Route('/api/companies/{id}', name: 'api_companies_delete', methods: ['DELETE'])]
    public function delete(int $id, CompanyRepository $companyRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $company = $companyRepository->find($id);
    
        if (!$company) {
            return $this->json(['message' => 'Company not found'], Response::HTTP_NOT_FOUND);
        }
    
        foreach ($company->getUsers() as $user) {
            $entityManager->remove($user);
        }
    
        $entityManager->remove($company);
        $entityManager->flush();
    
        return $this->json(['message' => 'Company deleted successfully.'], Response::HTTP_NO_CONTENT);
    }
    
    
}