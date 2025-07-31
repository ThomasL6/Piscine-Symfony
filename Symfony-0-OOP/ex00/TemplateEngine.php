<?php

class TemplateEngine
{
	public $fileName;
	public $templateName;
	public $parameters;

	function __construct($fileName, $templateName, $parameters)
	{
		$this->fileName = $fileName;
		$this->templateName = $templateName;
		$this->parameters = $parameters;
	}

	public function createFile($fileName, $templateName, $parameters)
	{
		$template = file_get_contents($templateName);
		if ($template === false) {
			throw new Exception("Le modèle $templateName n'a pas pu être chargé.");
		}
		foreach($parameters as $key => $value)
			$template = str_replace('{'. $key . '}', $value , $template);
		
		$result = file_put_contents($fileName, $template);
		if($result === false) {
			throw new Exception("Le fichier $fileName n'a pas pu être créé.");
		}
		else
			echo "Le fichier $fileName a été créé avec succès à partir du modèle $templateName.";
	}
	
}

?>