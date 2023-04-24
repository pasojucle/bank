<?php

namespace App\Form;

use App\Entity\Label;
use App\Entity\Month;
use App\Entity\Account;
use App\Entity\Category;
use App\Entity\Deadline;
use App\Form\Type\DatalistType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class DeadlineType extends AbstractType
{
    public const TRANSACTION_TYPE_DEBIT = 0;
    public const TRANSACTION_TYPE_CREDIT = 1;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', DatalistType::class, [
                'label' => 'Libellé',
                'class' => Label::class,
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
            ->add('creditAccount', EntityType::class, [
                'label' => 'Compte à créditer',
                'placeholder' => 'Aucun',
                'class' => Account::class,
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('debitAccount', EntityType::class, [
                'label' => 'Compte à débiter',
                'placeholder' => 'Aucun',
                'class' => Account::class,
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('amount', MoneyType::class, [
                'label' => 'Montant',
                'divisor' => 100,
            ])
            ->add('day', IntegerType::class, [
                'label' => 'Jour de prélèvement',
                'attr' => ['min' => 1, 'max' => 31],
            ])
            ->add('months', EntityType::class, [
                'label' => 'Mois de prélèvement',
                'multiple' => true,
                'class' => Month::class,
                'choice_label' => 'name',
                'expanded' => true,
                'attr' => ['class' => 'table-check'],
            ])
            ->add('endAt', DateType::class, [
                'label' => 'Dernière échéance',
                'input'  => 'datetime_immutable',
                'required' => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Deadline::class,
        ]);
    }
}
