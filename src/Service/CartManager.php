<?php 

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;

class CartManager
{
    public function setProductInfoToSession(Request $request)
    {
        $form = $request->request->get('form');
        $productId = $form['productId'];
        $quantity = $form['quantity'];

        $productInfo = [
            'productId' => $productId,
            'quantity' => $quantity,
        ]; 
        
        $_SESSION['cart'][] = $productInfo;

        return true;
    }

    public function getProductInfoFromSession($info)
    {
        if (isset($_SESSION['cart'])) {
            $count = count($_SESSION['cart']);
            for ($i = 0; $i < $count; $i++) { 
                $result[] = $_SESSION['cart'][$i]["$info"];
            }
            return $result;   
        }

        return false;
    }

    public function getResultProductsInfo(array $productsInCart, array $productsQuantity): array
    {   
        $count = count($productsQuantity);
        for ($i = 0; $i < $count; $i++) { 
            $result[] = [
                'product' => $productsInCart[$i],
                'quantity' => $productsQuantity[$i],
            ]; ;
        }

        return $result;
    }
}