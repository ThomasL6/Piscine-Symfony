<?php

class Elem
{
    private string $element;
    private array|string|null $content;
    private static array $validTags = ["meta", "img", "hr", "br", "html", "head", "body", "title", "h1", "h2", "h3", "h4", "h5", "h6", "p", "span", "div"];

    function __construct(string $element, $content = '')
    {
        // Validation de la balise dans le constructeur
        if (!in_array($element, self::$validTags)) {
            throw new InvalidArgumentException("Balise HTML invalide : {$element}");
        }
        
        $this->element = $element;
        $this->content = $content;
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
        // Plus besoin de vérifier ici car c'est fait dans le constructeur
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
}

?>