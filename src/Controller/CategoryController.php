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

    public function menuCategory(CategoryRepository $categoryRepository)
    {   
        //get categories, where parent = null
        $categories = $categoryRepository->findBy(['parent' => null ]);

        return $this->render('category/partial/menu_category.html.twig', compact('categories'));       
    }
}
