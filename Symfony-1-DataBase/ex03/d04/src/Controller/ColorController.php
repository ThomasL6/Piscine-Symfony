<?php

	namespace App\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

	class ColorController extends AbstractController
	{
		#[Route('/e03', name: 'color')]
		public function index(): Response
		{
			$numberOfColors = $this->getParameter('e03.number_of_colors');
			$colors = ['blue', 'red', 'green', 'black', ];
			
			$shades = [];
			for ($i = 0; $i < $numberOfColors; $i++)
			{
				$ratio = (int)(255 * ($i / ($numberOfColors - 1)));
				$shades[] = [
					'black' => sprintf(
					'rgb(%d, %d, %d)',
					$ratio,
					$ratio,
					$ratio
				),
				'red' => sprintf(
					'rgb(%d, 0, 0)',
					$ratio
				),
				'green' => sprintf(
					'rgb(0, %d, 0)',
					$ratio
				),
				'blue' => sprintf(
					'rgb(0, 0, %d)',
					$ratio
				)
			];
		}
		return $this->render('e03/index.html.twig', [ 'shades' => $shades, 'colors' => $colors ]);
	}
}