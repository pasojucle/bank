<?php

namespace App\Form\Type;

use Symfony\Component\Form\FormView;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\DataTransformer\EntityToPropertyTransformer;
use Doctrine\ORM\EntityManagerInterface;

class DatalistType extends AbstractType
{

    protected ObjectManager $em;

    public function __construct(protected EntityManagerInterface $entityManager, protected Security $security)
    {
    
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired([
            'class',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer(new EntityToPropertyTransformer($this->entityManager, $this->security, $options['class']));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['class'] = $options['class'];
        $view->vars['compound'] = false;
    }

    public function getName(): string
    {
        return 'datalist';
    }

    public function getBlockPrefix(): string
    {
        return 'datalist';
    }
}