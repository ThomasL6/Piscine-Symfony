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

	public function createFile($fileName, $text)
	{
		$template = file_get_contents($this->templateName);

		if ($template === false)
		{
			throw new Exception("Le modèle $this->templateName n'a pas pu être chargé.");
		}

		$params = $this->parameters;
		$params['content'] = $text->readData();

		foreach ($params as $key => $value)
		{
			$template = str_replace('{' . $key . '}', $value, $template);
		}

		$result = file_put_contents($fileName, $template);

		if ($result === false)
		{
			throw new Exception("Le fichier $fileName n'a pas pu être créé.");
		}
		else
		{
			echo "Le fichier $fileName a été créé avec succès à partir du modèle $this->templateName.\n";
		}
	}
}

?>
