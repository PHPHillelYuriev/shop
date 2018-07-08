<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Service\LastViewProductsManager;
use App\Service\FormManager;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;
use App\Service\ProductCrudManager;

/**
 * @Route("/OneTech")
 */
class ProductController extends Controller
{
    /**
     * @Route("/shop", name="shop")
     */
    public function shop()
    {
        return $this->render('product/shop.html.twig');
    }

    /**
     * @Route("/shop/{productManufacture}_{productModel}", name="showOneProduct")
     * @ParamConverter("product", options={"mapping": {"productManufacture" = "manufacturer", "productModel" = "model"}})
     */
    public function showOneProduct(Product $product)
    {
        $lastViewProducts = $this->get(LastViewProductsManager::class)->getLastViewProducts();
        $this->get(LastViewProductsManager::class)->addLastViewProducts($product);

        $form = $this->get(FormManager::class)->createCartForm($product);

        return $this->render('product/product.html.twig', compact('product', 'lastViewProducts', 'form'));
    }

    /**
     * @Route("/admin/products", name="showProducts")
     */
    public function showProducts(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();

        return $this->render('product/partial/product.html.twig', compact('products'));
    }

    /**
     * @Route("admin/product/add", name="addProduct", methods="GET|POST")
     */
    public function addProduct(Request $request)
    {
        $pcm = $this->get(ProductCrudManager::class);
        $result = $pcm->addProduct($request);

        //if product add to DB
        if (!$result) {
            $message = 'You add new product!';
            $this->addFlash('success', $message);

            return $this->redirectToRoute('showProducts');
        }

        return $this->render('product/partial/add.html.twig', $result);
    }

    /**
     * @Route("admin/product/{product}/edit", name="editProduct", methods="GET|POST")
     */
    public function editCategory(Request $request, Product $product)
    {
        $pcm = $this->get(ProductCrudManager::class);
        $result = $pcm->editProduct($request, $product);

        //if product edit
        if (!$result) {
            $message = 'You edit product!';
            $this->addFlash('success', $message);

            return $this->redirectToRoute('showProducts');
        }

        return $this->render('product/partial/update.html.twig', $result);
    }

    /**
     * @Route("admin/product/{product}/delete", name="deleteProduct")
     */
    public function deleteCategory(Request $request, Product $product)
    {
        $pcm = $this->get(ProductCrudManager::class);
        $result = $pcm->deleteCategory($product);

        if (!$result) {
            $message = 'You delete a product!';
            $this->addFlash('success', $message);
        }

        return $this->redirectToRoute('showProducts');
    }
}
