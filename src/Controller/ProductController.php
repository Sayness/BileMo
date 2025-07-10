<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Customer;
use Hateoas\HateoasBuilder;
use OpenApi\Annotations as OA;
use App\Repository\ProductRepository;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;


class ProductController extends AbstractController
{
    /**
     * @OA\Get(
     *    path="/api/product",
     *   summary="Liste des produits",
     *   @OA\Response(response=200, description="tous les produits"),
     *   @OA\Response(response=404, description="Aucun produit trouvé"),
     *  
     * )
     * 
     * @Route("/api/product", name="api_product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository,SerializerInterface $serializer)
    {
      $hateoas = HateoasBuilder::create()->build();
      $products = $productRepository->findAll();

      $json = $hateoas->serialize($products, 'json', SerializationContext::create()->setGroups(array('product:read')));
        return new JsonResponse($json, 200, [], true);


    }

  

    /**
     * @OA\Get(
     *     path="/api/product/{id}",
     *   summary="Recuperer un produit par ID",
     *   @OA\PathParameter(
     *     name="id",
     *     description="l'id du produit que vous voulez recuperer"
     *   ),
     *   @OA\Response(
     *       response="200",
     *       description="Detail du produit",
     *       @OA\JsonContent(ref="#/components/schemas/Product")
     *   ),
     *   @OA\Response(response=404, description="Aucun produit trouvé avec cet ID")
     * )
     *
     * @Route("/api/product/{id}", name="api_product_show", methods={"GET"})
     */
    public function api_find_product(ProductRepository $productRepository,$id, SerializerInterface $serializer)
    {
      try{
        $hateoas = HateoasBuilder::create()->build();

        $product = $productRepository->find($id);
        if ($product === null) {
         return $this->json([
             'status' => 404,
             'message' => "Aucun produit trouvé"
         ], 404);
     }
        $json = $hateoas->serialize($product, 'json', SerializationContext::create()->setGroups(array('product:read')));
        return new JsonResponse($json,Response::HTTP_OK, [], true);

      }catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ], 400);
        }
     
  


        
    }

}
