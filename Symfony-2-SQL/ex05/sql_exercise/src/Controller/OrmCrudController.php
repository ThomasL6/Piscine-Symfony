<?php

namespace App\Controller;

use App\Entity\UserOrm;
use App\Form\UserOrmType;
use App\Service\UserOrmService;
use App\Repository\UserOrmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrmCrudController extends AbstractController
{
	#[Route('/ormcrud', name: 'app_ormcrud')]
	public function index(
		Request $request,
		UserOrmService $service
	): Response
	{
		$user = new UserOrm();

		$form = $this->createForm(
			UserOrmType::class,
			$user
		);

		$form->handleRequest($request);

		$message = '';

		if (
			$form->isSubmitted()
			&& $form->isValid()
		)
		{
			$saved = $service->save($user);

			if ($saved)
			{
				$message = 'User inserted successfully.';
			}
			else
			{
				$message = 'User already exists.';
			}
		}

		return $this->render('ormcrud/index.html.twig', [
			'form' => $form->createView(),
			'users' => $service->getAll(),
			'message' => $message,
		]);
	}

	#[Route(
		'/ormcrud/delete/{id}',
		name: 'app_ormcrud_delete'
	)]
	public function delete(
		int $id,
		UserOrmRepository $repository,
		EntityManagerInterface $entityManager
	): Response
	{
		$message = '';

		$user = $repository->find($id);

		if ($user)
		{
			$entityManager->remove($user);

			$entityManager->flush();

			$message = 'User deleted successfully.';
		}
		else
		{
			$message = 'User does not exist.';
		}

		return $this->redirectToRoute('app_ormcrud');
	}
}