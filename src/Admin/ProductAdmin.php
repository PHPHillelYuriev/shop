<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Category;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Product')
                ->with('Content', ['class' => 'col-md-9'])
                    ->add('model', TextType::class)
                    ->add('manufacturer', TextType::class)
                ->end()
            ->end()

            ->tab('Data Option')
                ->with('Meta Data', ['class' => 'col-md-3'])
                    ->add('category', ModelType::class, [
                        'class' => Category::class,
                        'property' => 'name',
                    ])
                ->end()
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('model')
            ->add('manufacturer')
            ->add('category', null, [], EntityType::class, [
                'class'    => Category::class,
                'choice_label' => 'name',
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->addIdentifier('model')
            ->add('manufacturer')
            ->add('price')
            ->add('category.name', null, ['editable' => true])
            ->add('date_added', null, [
                'format' => 'Y-m-d H:i',
            ])
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }

    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('model')
            ->add('manufacturer')
            ->add('price')
            ->add('category.name')
        ;
    }

    public $supportsPreviewMode = true;

}