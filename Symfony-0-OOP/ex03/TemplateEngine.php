<?php

class TemplateEngine
{
	private Elem $elem;
	private string $templateName;

	public function __construct(Elem $elem, string $templateName)
	{
		$this->elem = $elem;
		$this->templateName = $templateName;
	}

	public function createFile(string $fileName): void
	{
		$html = $this->elem->getHTML(); // Génère l'arbre HTML complet

		$result = file_put_contents($fileName, $html);

		if ($result === false)
		{
			throw new Exception("Le fichier $fileName n'a pas pu être créé.");
		}
		else
		{
			echo "Le fichier $fileName a été créé avec succès.\n";
		}
	}
}
