<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrmController extends AbstractController
{
    #[Route('/orm', name: 'app_orm')]
    public function index(): Response
    {
        return $this->render('orm/index.html.twig');
    }

    #[Route('/orm/create-table', name: 'app_orm_create')]
    public function createTable(EntityManagerInterface $entityManager): Response
    {
        $message = '';

        try
        {
            $metadata = [
                $entityManager->getClassMetadata(User::class)
            ];

            $schemaTool = new SchemaTool($entityManager);

            $schemaTool->updateSchema($metadata);

            $message = 'Table created successfully.';
        }
        catch (\Exception $e)
        {
            $message = 'Error : ' . $e->getMessage();
        }

        return $this->render('orm/index.html.twig', [
            'message' => $message,
        ]);
    }
}