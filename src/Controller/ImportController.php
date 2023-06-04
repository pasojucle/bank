<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/import')]
class ImportController extends AbstractController
{

    #[Route('/{id}/{account}', name: 'import_edit', methods: ['POST', 'GET'], options: ['expose' => true])]
    public function import(int $id, int $account): Response
    {
        
        return $this->render('import/edit.html.twig', [
            'id' => $id,
            'account' => $account,
        ]);
    }
}