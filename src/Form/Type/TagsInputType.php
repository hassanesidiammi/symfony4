<?php

namespace App\Form\Type;

use App\Form\DataTransformer\ArrayTagsToStringTransformer;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class TagsInputType extends AbstractType
{

    /**
     * @var TagRepository
     */
    private $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new CollectionToArrayTransformer(), true)
            ->addModelTransformer(new ArrayTagsToStringTransformer($this->repository), true)
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['tags'] = $this->repository->findAll();
    }


    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return TextType::class;
    }
}
