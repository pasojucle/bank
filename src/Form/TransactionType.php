<?php

namespace App\Form;

use App\Entity\Label;
use App\Entity\Category;
use App\Entity\Transaction;
use App\Form\Type\DatalistType;
use App\Repository\LabelRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TransactionType extends AbstractType
{
    public function __construct(private LabelRepository $labelRepository)
    {
        
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt', DateType::class, [
                'label' => 'Date',
                'input'  => 'datetime_immutable'
            ])
            ->add('label', DatalistType::class, [
                'label' => 'Libellé',
                'class' => Label::class,
                // 'choice_label' => 'name',
                // 'choices' => $this->labelRepository->findAllASC(),
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.name', 'ASC');
                },
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => Category::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
            ])
            ->add('amount', MoneyType::class, [
                'label' => 'Montant',
                'divisor' => 100,
            ])
            ->add('transactionType', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Dépense' => 0,
                    'Revenue' => 1,
                ],
                'mapped' => false,
            ])
            ->add('comment', TextType::class, [
                'label' => 'Commentaire'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
