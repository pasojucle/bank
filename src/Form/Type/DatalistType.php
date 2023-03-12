<?php

namespace App\Form\Type;

use Symfony\Component\Form\FormView;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\DataTransformer\EntityToPropertyTransformer;

class DatalistType extends AbstractType
{

    protected ObjectManager $em;

    public function __construct(protected ManagerRegistry $registry)
    {
        $this->registry = $registry;
        $this->em = $registry->getManager();
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'class',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $manager = $this->registry->getManagerForClass($options['class']);
        if ($manager instanceof ObjectManager) {
            $this->em = $manager;
        }
        $builder->addModelTransformer(new EntityToPropertyTransformer($manager, $options['class']));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        dump($options);
        $view->vars['class'] = $options['class'];
        $view->vars['compound'] = false;
        // $view->vars['choices'] = $options['choices'];
    }

    public function getName()
    {
        return 'datalist';
    }

    public function getBlockPrefix()
    {
        return 'datalist';
    }
}