<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SqlCrudController extends AbstractController
{
	#[Route('/sqlcrud', name: 'app_sqlcrud')]
	public function index(Connection $connection): Response
	{
		$query = "
			CREATE TABLE IF NOT EXISTS users_crud (
				id INT AUTO_INCREMENT PRIMARY KEY,
				username VARCHAR(255) UNIQUE NOT NULL,
				name VARCHAR(255) NOT NULL,
				email VARCHAR(255) UNIQUE NOT NULL,
				enabled BOOLEAN NOT NULL,
				birthdate DATETIME NOT NULL,
				address LONGTEXT NOT NULL
			)
		";

		$connection->executeStatement($query);

		$users = $connection->fetchAllAssociative(
			"SELECT * FROM users_crud"
		);

		return $this->render('sqlcrud/index.html.twig', [
			'users' => $users,
		]);
	}

	#[Route('/sqlcrud/add', name: 'app_sqlcrud_add', methods: ['POST'])]
	public function addUser(
		Request $request,
		Connection $connection
	): Response
	{
		$message = '';

		$username = $request->request->get('username');
		$name = $request->request->get('name');
		$email = $request->request->get('email');
		$enabled = $request->request->get('enable') ? 1 : 0;
		$birthdate = $request->request->get('birthdate');
		$address = $request->request->get('address');

		try
		{
			$existingUser = $connection->fetchAssociative(
				"
					SELECT * FROM users_crud
					WHERE username = ?
					OR email = ?
				",
				[$username, $email]
			);

			if (!$existingUser)
			{
				$connection->insert('users_crud', [
					'username' => $username,
					'name' => $name,
					'email' => $email,
					'enabled' => $enabled,
					'birthdate' => $birthdate,
					'address' => $address,
				]);

				$message = 'User added successfully.';
			}
			else
			{
				$message = 'Username or email already exists.';
			}
		}
		catch (Exception $e)
		{
			$message = 'Error : ' . $e->getMessage();
		}

		$users = $connection->fetchAllAssociative(
			"SELECT * FROM users_crud"
		);

		return $this->render('sqlcrud/index.html.twig', [
			'message' => $message,
			'users' => $users,
		]);
	}
}
