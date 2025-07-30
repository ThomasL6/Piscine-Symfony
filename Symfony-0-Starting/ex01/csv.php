<?php

function read($file)
{
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . $file;

    if (file_exists($filePath) && is_readable($filePath))
    {
        $content = file_get_contents($filePath);

        $elements = explode(",", $content);

        foreach ($elements as $element)
            echo trim($element) . "\n";
    }
    else
    {
        echo "Erreur : le fichier n'existe pas ou n'est pas lisible.";
    }
}

read("ex01.txt");
?>
