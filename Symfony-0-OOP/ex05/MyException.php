<?php

class MyException extends Exception
{
    public function errorMessage(): string
    {
        return "Erreur dans le fichier {$this->getFile()} à la ligne {$this->getLine()}: {$this->getMessage()}";
    }
}
