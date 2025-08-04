<?php
require_once 'MyException.php';
class Elem
{
    private string $element;
    private array|string|Elem|null $content;

    private array $attributes = [];
    private static array $validTags = ["meta", "img", "hr", "br", "html", "head", "body", "title", "h1", "h2", "h3", "h4", "h5", 
    "h6", "p", "span", "div", "table", "tr", "th", "td", "ul", "ol", "li"];

    function __construct(string $element, $content = '', array $attributes = [])
    {
        $this->element = $element;
        $this->content = $content;
        $this->attributes = $attributes;
        if (!in_array($this->element, self::$validTags)) {
            throw new MyException("Balise HTML invalide : {$this->element}");
        }
    }

    public function pushElement($elem): void
    {
        if (!is_string($elem) && !($elem instanceof Elem)) {
            throw new InvalidArgumentException("Le contenu doit être une chaîne ou un objet Elem");
        }

        if (!is_array($this->content)) {
            $this->content = $this->content ? [$this->content] : [];
        }

        $this->content[] = $elem;
    }

    public function getHTML(int $indentLevel = 0): string
	{
		if (!in_array($this->element, self::$validTags)) {
			throw new InvalidArgumentException("Balise HTML invalide : {$this->element}");
		}

		$indent = str_repeat("  ", $indentLevel); // 2 espaces par niveau
		$html = "{$indent}<{$this->element}>";

		if (is_array($this->content)) {
			$html .= "\n";
			foreach ($this->content as $child) {
				if ($child instanceof Elem) {
					$html .= $child->getHTML($indentLevel + 1) . "\n";
				} else {
					$html .= str_repeat("  ", $indentLevel + 1) . htmlspecialchars((string)$child) . "\n";
				}
			}
			$html .= "{$indent}</{$this->element}>";
		} else {
			if ($this->content instanceof Elem) {
				$html .= "\n" . $this->content->getHTML($indentLevel + 1) . "\n" . "{$indent}</{$this->element}>";
			} else {
				$html .= htmlspecialchars((string)$this->content) . "</{$this->element}>";
			}
		}

		return $html;
	}
}

?>
