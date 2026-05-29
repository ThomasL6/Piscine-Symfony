<?php

namespace App\Controller;

use App\Entity\UserOrm;
use App\Form\UserOrmType;
use App\Service\UserOrmService;
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
}
