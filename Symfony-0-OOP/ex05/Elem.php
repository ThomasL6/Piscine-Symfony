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

		$indent = str_repeat("  ", $indentLevel);
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

	public function getElement(): string
	{
		return $this->element;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getAttributes(): array
	{
		return $this->attributes;
	}

	public function validPage():bool
	{
		// Vérifier que l'élément racine est 'html'
		if ($this->element !== 'html') {
			return false;
		}

		// Vérifier que le contenu est un tableau (car html doit avoir des enfants)
		if (!is_array($this->content)) {
			return false;
		}

		$headCount = 0;
		$bodyCount = 0;

		// Parcourir tous les éléments enfants
		foreach ($this->content as $child) {
			// Ignorer les éléments qui ne sont pas des objets Elem
			if (!($child instanceof Elem)) {
				continue;
			}

			// Compter les éléments head et body
			if ($child->getElement() === 'head') {
				$headCount++;
				// Valider le contenu du head
				if (!$this->validateHead($child)) {
					return false;
				}
			} elseif ($child->getElement() === 'body') {
				$bodyCount++;
				// Valider le contenu du body
				if (!$this->validateElement($child)) {
					return false;
				}
			}
		}

		// Vérifier qu'il y a exactement un head et un body
		return ($headCount === 1 && $bodyCount === 1);
	}

	private function validateHead(Elem $head): bool
	{
		$headContent = $head->getContent();
		if (!is_array($headContent)) {
			return true; // head vide est valide
		}

		$titleCount = 0;
		$metaCharsetCount = 0;

		foreach ($headContent as $child) {
			if (!($child instanceof Elem)) {
				continue;
			}

			$elementType = $child->getElement();
			
			if ($elementType === 'title') {
				$titleCount++;
				// Vérifier que title ne contient que du texte
				if (!$this->validateTextOnly($child)) {
					return false;
				}
			} elseif ($elementType === 'meta') {
				// Vérifier si c'est un meta charset
				$attributes = $child->getAttributes();
				if (isset($attributes['charset'])) {
					$metaCharsetCount++;
				}
			}

			// Valider récursivement l'élément
			if (!$this->validateElement($child)) {
				return false;
			}
		}

		// Un seul title et un seul meta charset maximum
		return ($titleCount <= 1 && $metaCharsetCount <= 1);
	}

	private function validateElement(Elem $element): bool
	{
		$elementType = $element->getElement();

		switch ($elementType) {
			case 'p':
				return $this->validateTextOnly($element);
			
			case 'table':
				return $this->validateTable($element);
			
			case 'ul':
			case 'ol':
				return $this->validateList($element);
			
			case 'tr':
				return $this->validateTableRow($element);
			
			default:
				// Pour les autres éléments, valider récursivement leurs enfants
				return $this->validateChildren($element);
		}
	}

	private function validateTextOnly(Elem $element): bool
	{
		$content = $element->getContent();
		if (!is_array($content)) {
			// Contenu simple (string) ou null - valide pour un élément texte
			return true;
		}

		// Si c'est un tableau, tous les éléments doivent être du texte (string)
		foreach ($content as $child) {
			if ($child instanceof Elem) {
				return false; // p ne doit contenir que du texte
			}
		}

		return true;
	}

	private function validateTable(Elem $table): bool
	{
		$content = $table->getContent();
		if (!is_array($content)) {
			return true; // table vide est techniquement valide
		}

		foreach ($content as $child) {
			if (!($child instanceof Elem)) {
				continue; // ignorer le texte
			}

			// Table ne doit contenir que des tr
			if ($child->getElement() !== 'tr') {
				return false;
			}

			// Valider le tr
			if (!$this->validateTableRow($child)) {
				return false;
			}
		}

		return true;
	}

	private function validateTableRow(Elem $tr): bool
	{
		$content = $tr->getContent();
		if (!is_array($content)) {
			return true; // tr vide est valide
		}

		foreach ($content as $child) {
			if (!($child instanceof Elem)) {
				continue; // ignorer le texte
			}

			$childElement = $child->getElement();
			// tr ne doit contenir que th ou td
			if ($childElement !== 'th' && $childElement !== 'td') {
				return false;
			}

			// Valider récursivement th/td
			if (!$this->validateElement($child)) {
				return false;
			}
		}

		return true;
	}

	private function validateList(Elem $list): bool
	{
		$content = $list->getContent();
		if (!is_array($content)) {
			return true; // liste vide est valide
		}

		foreach ($content as $child) {
			if (!($child instanceof Elem)) {
				continue; // ignorer le texte
			}

			// ul/ol ne doit contenir que des li
			if ($child->getElement() !== 'li') {
				return false;
			}

			// Valider récursivement li
			if (!$this->validateElement($child)) {
				return false;
			}
		}

		return true;
	}

	private function validateChildren(Elem $element): bool
	{
		$content = $element->getContent();
		if (!is_array($content)) {
			return true;
		}

		foreach ($content as $child) {
			if ($child instanceof Elem) {
				if (!$this->validateElement($child)) {
					return false;
				}
			}
		}

		return true;
	}
}

?>
