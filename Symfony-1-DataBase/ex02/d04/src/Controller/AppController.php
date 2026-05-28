<?php

	namespace App\Controller;

	use App\Form\NotesType;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\Routing\Annotation\Route;

	class AppController extends AbstractController
	{
		#[Route('/e02', name: 'e02')]
		public function index(Request $request): Response
		{
			$form = $this->createForm(NotesType::class);
			$form->handleRequest($request);
			$lastLine = null;
			
			if($form->isSubmitted() && $form->isValid())
			{
				$data = $form->getData();
				$filename = $this->getParameter('notes_file');
				$line = $data['message'];

				if($data['timestamp'] === 'yes')
				{
					date_default_timezone_set('Europe/Paris');
					$line = date('Y-m-d H:i:s') . ' - ' . $line;
				}
				$line .= PHP_EOL;
				file_put_contents($filename, $line, FILE_APPEND);
				$lastLine = trim($line);
			}
			return $this->render('/e02/index.html.twig', [
				'form' => $form->createView(),
				'last_line' => $lastLine
			]);
		}
	}