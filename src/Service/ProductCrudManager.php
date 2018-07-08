<?php

namespace App\Service;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;

class ProductCrudManager
{
    private $entityManager;
    private $formFactory;

    function __construct(EntityManagerInterface $entityManager, FormFactoryInterface $formFactory)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    public function addProduct(Request $request)
    {
        $category = new Product();

        return $this->editProduct($request, $category);
    }

    public function editProduct(Request $request, Product $product)
    {
        $form = $this->formFactory->create(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($product);

            return;
        }

        return [
            'category' => $product,
            'form' => $form->createView(),
        ];
    }

    private function save(Product $product)
    {
        if (!$product->getId()) {
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return;
        }

        $this->entityManager->flush();
    }

    public function deleteCategory(Product $product)
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return;
    }
}