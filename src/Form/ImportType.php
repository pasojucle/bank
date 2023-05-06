<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
class ImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('file', FileType::class, [
            'label' => false,
            'attr' => [
                'accept' => "text/csv"
            ],
            // 'constraints' => [
            //     new File([
            //         'maxSize' => '1024k',
            //         'mimeTypes' => [
            //             'text/csv',
            //         ],
            //         'mimeTypesMessage' => 'Sélectionner un fichier de type csv',
            //     ])
            // ],
        ])
        ;
    }
}
