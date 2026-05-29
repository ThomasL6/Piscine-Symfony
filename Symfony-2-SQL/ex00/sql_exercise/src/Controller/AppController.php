<?php

	namespace App\Controller;

	
	use Doctrine\DBAL\Connection;
	use Doctrine\DBAL\Exception;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Attribute\Route;

	class AppController extends AbstractController
	{
		#[Route('/sql', name: 'app_sql')]
		public function index(Connection $connection): Response
		{
			return ($this->render('sql/index.html.twig'));
		}

		#[Route('/sql/create-table', name: 'app_sql_create_table')]
		public function createTable(Connection $connection): Response
		{
			$message = '';

			$query = "
				CREATE TABLE IF NOT EXISTS users (
					id INT AUTO_INCREMENT PRIMARY KEY,
					username VARCHAR(255) UNIQUE NOT NULL,
					name VARCHAR(255) NOT NULL,
					email VARCHAR(255) UNIQUE NOT NULL,
					enable BOOLEAN NOT NULL,
					birthdate DATETIME NOT NULL,
					address LONGTEXT NOT NULL
				)
			";

			try
			{
				$connection->executeStatement($query);
				$message = 'Table created successfully.';
			}
			catch (Exception $e)
			{
				$message = 'Error : ' . $e->getMessage();
			}

			return $this->render('sql/index.html.twig', [
				'message' => $message,
			]);
		}
}