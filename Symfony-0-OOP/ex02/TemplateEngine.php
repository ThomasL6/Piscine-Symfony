<?php

class TemplateEngine
{
	private $templateName;
	private $parameters;

	public function __construct($templateName, $parameters)
	{
		$this->templateName = $templateName;
		$this->parameters = $parameters;
	}

	public function createFile($HotBeverage)
	{
		$template = file_get_contents($this->templateName);

		if ($template === false)
		{
			throw new Exception("Le modèle $this->templateName n'a pas pu être chargé.");
		}

		$params = $this->parameters;

		$mapping = [
			'nom' => 'getName',
			'price' => 'getPrice',
			'resistance' => 'getResistance',
			'description' => 'getDescription',
			'comment' => 'getComment'
		];

		foreach ($mapping as $key => $getter)
		{
			if (method_exists($HotBeverage, $getter))
			{
				$value = $HotBeverage->$getter();

				if (is_float($value))
				{
					$value = number_format($value, 2); // formatage pour l'euro
				}
				$params[$key] = htmlspecialchars((string)$value);
			}
		}

		foreach ($params as $key => $value)
		{
			$template = str_replace('{' . $key . '}', $value, $template);
		}

		$filename = $HotBeverage->getName() . '.html';

		$result = file_put_contents($filename, $template);

		if ($result === false)
		{
			throw new Exception("Le fichier $filename n'a pas pu être créé.");
		}
		else
		{
			echo "Le fichier $filename a été créé avec succès à partir du modèle $this->templateName.\n";
		}
	}



}
?>
