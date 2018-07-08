<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CategoryType;
use App\Service\CategoryCrudManager;

class CategoryController extends Controller
{
    /**
      * @Route("/OneTech/categories/{category}", name="showProductsByCategory")
      * @ParamConverter("category", options={"mapping": {"category" = "name"}})
      */
    public function showProductsByCategory(Request $request, Category $category, ProductRepository $productRepository)
    {   
        //get unique product manufacturers
        $productManufacturers = $productRepository->getUniqueProductManufacturer($category->getId());

        $query = $productRepository->getQueryForPagination($category->getId());

        //create pagination
        $pagination = $this->get('knp_paginator')->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );
        $pagination->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');

        return $this->render('category/category.html.twig', compact('pagination', 'productManufacturers'));
    }

    /**
     * @Route("/admin/categories", name="showCategories")
     */
    public function showCategories(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('admin/category.html.twig', compact('categories'));
    }

    /**
     * @Route("admin/category/add", name="addCategory", methods="GET|POST")
     */
    public function addCategory(Request $request)
    {
        $ccm = $this->get(CategoryCrudManager::class);
        $result = $ccm->addCategory($request);

        //if category add to DB
        if (!$result) {
            $message = 'You add new category!';
            $this->addFlash('success', $message);

            return $this->redirectToRoute('showCategories');
        }

        return $this->render('admin/add.html.twig', $result);
    }

    /**
     * @Route("admin/category/{category}/edit", name="editCategory", methods="GET|POST")
     */
    public function editCategory(Request $request, Category $category)
    {
        $ccm = $this->get(CategoryCrudManager::class);
        $result = $ccm->editCategory($request, $category);

        //if category edit
        if (!$result) {
            $message = 'You edit category!';
            $this->addFlash('success', $message);

            return $this->redirectToRoute('showCategories');
        }

        return $this->render('admin/update.html.twig', $result);
    }

    /**
     * @Route("admin/category/{category}/delete", name="deleteCategory")
     */
    public function deleteCategory(Request $request, Category $category)
    {
        $ccm = $this->get(CategoryCrudManager::class);
        $result = $ccm->deleteCategory($category);

        if (!$result) {
            $message = 'You delete a category!';
            $this->addFlash('success', $message);
        }

        return $this->redirectToRoute('showCategories');
    }

    public function menuCategory(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findBy(['parent' => null ]);

        return $this->render('category/partial/menu_category.html.twig', compact('categories'));
    }
}
