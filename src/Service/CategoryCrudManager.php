<?php

namespace App\Service;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;

class CategoryCrudManager
{
    private $entityManager;
    private $formFactory;

    function __construct(EntityManagerInterface $entityManager, FormFactoryInterface $formFactory)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    public function addCategory(Request $request)
    {
        $category = new Category();

        return $this->editCategory($request, $category);
    }

    public function editCategory(Request $request, Category $category)
    {
        $form = $this->formFactory->create(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($category);

            return;
        }

        return [
            'category' => $category,
            'form' => $form->createView(),
        ];
    }

    private function save(Category $category)
    {
        if (!$category->getId()) {
            $this->entityManager->persist($category);
            $this->entityManager->flush();

            return;
        }

        $this->entityManager->flush();
    }

    public function deleteCategory(Category $category)
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return;
    }
}