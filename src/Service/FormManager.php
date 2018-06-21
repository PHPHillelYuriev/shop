<?php 

namespace App\Service;

use Symfony\Component\Form\FormFactoryInterface;
use App\Form\FormType;

class FormManager
{   
    private $formFactory;    

    public function __construct(FormFactoryInterface $formFactory) 
    {
        $this->formFactory = $formFactory;
    }

    public function createCartForm($product)
    {   
        $defaultData = ['productId' => $product->getId()];

        $form = $this->formFactory->create(FormType::class, $defaultData);

        return $form->createView();    
    }    
}