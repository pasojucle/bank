<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\Transformer\HiddenEntityTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * Entity hidden custom type class definition.
 */
class HiddenAccountType extends HiddenType
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // attach the specified model transformer for this entity list field
        // this will convert data between object and string formats

        $builder->addModelTransformer(new HiddenEntityTransformer($this->entityManager, Account::class));
    }
}