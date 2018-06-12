<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CategoryController extends Controller
{
    /**
      * @Route("/OneTech/{category}", name="showProductsByCategory")
      * @ParamConverter("category", options={"mapping": {"category" = "name"}})
      */
    public function showProductsByCategory(Category $category, ProductRepository $productRepository)
    {   
        //get unique product manufacturer
        $productManufacturers = $productRepository->getUniqueProductManufacturer();

        return $this->render('category/category.html.twig', compact('category', 'productManufacturers'));
    }

    public function categories(CategoryRepository $categoryRepository)
    {   
        //get categories, where parent = null
        $categories = $categoryRepository->getFirstLevelCategories();

        return $this->render('category/partial/categories.html.twig', compact('categories'));       
    }
}
