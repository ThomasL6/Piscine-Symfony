<?php

class Text
{
	private $content;

	public function __construct(array $lines)
	{
		$this->content = $lines;
	}

	public function append(string $line)
	{
		$this->content[] = $line;
	}

	public function readData()
	{
		$result = [];

		foreach ($this->content as $line)
		{
			$line = trim($line);

			if ($line !== '')
			{
				$result[] = "<p>" . htmlspecialchars($line) . "</p>";
			}
		}

		return implode("\n", $result);
	}
}

?>
