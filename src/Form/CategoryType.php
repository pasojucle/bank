<?php

namespace App\Form;


use App\Entity\Cluster;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Enum\CategoryType as EnumCategoryType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('type', EnumType::class, [
                'label' => 'Groupe de dépence',
                'class' => EnumCategoryType::class,
                'choice_label' => fn ($choice) => match ($choice) {
                    EnumCategoryType::REVENUE => 'category_type.revenu',
                    EnumCategoryType::EXPENSE => 'category_type.expense',
                    EnumCategoryType::SAVING => 'category_type.saving',
                    default => '',
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
