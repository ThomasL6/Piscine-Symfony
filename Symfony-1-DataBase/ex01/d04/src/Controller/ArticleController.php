<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
	private function getNavigation(): array
	{
		return [
			[
				'url' => '',
				'name' => 'Main page'
			],
			[
				'url' => 'gull',
				'name' => 'Gulls'
			],
			[
				'url' => 'seal',
				'name' => 'Seals'
			],
			[
				'url' => 'turtle',
				'name' => 'Turtles'
			]

		];
	}

	#[Route('/e01', name: 'home')]
	public function home(): Response
	{
		return $this->render(
			'e01/home.html.twig',
			[
				'navigation' => $this->getNavigation()
			]
		);
	}

	#[Route('/e01/{article}', name: 'article')]
	public function article(string $article): Response
	{
		$navigation = $this->getNavigation();

		$validArticles = array_column(
			$navigation,
			'url'
		);

		if (!in_array($article, $validArticles))
		{
			return $this->render(
				'e01/home.html.twig',
				[
					'navigation' => $navigation
				]
			);
		}

		return $this->render(
			sprintf('e01/%s.html.twig', $article),
			[
				'navigation' => $navigation
			]
		);
	}
}