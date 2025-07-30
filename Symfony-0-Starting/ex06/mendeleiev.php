<?php

// Lire le contenu du fichier ex06.txt
$file = fopen("ex06.txt", "r");
if (!$file) {
    die("Impossible d'ouvrir le fichier ex06.txt");
}

// Tableau pour stocker tous les éléments
$elements = [];

// Lire chaque ligne du fichier ex06.txt
while (($line = fgets($file)) !== false) {
    $line = trim($line); // Enlever les espaces superflus
    if (empty($line)) continue; // Passer les lignes vides

    // Extraire les informations des éléments chimiques
    $parts = explode(" = ", $line);
    $name = $parts[0];  // Nom de l'élément
    $attributes = explode("; ", $parts[1]);  // Attributs de l'élément

    // Extraire les détails
    $details = [];
    foreach ($attributes as $attr) {
        $attrParts = explode(":", $attr);
        $details[trim($attrParts[0])] = trim($attrParts[1]);
    }

    // Ajouter l'élément au tableau avec sa position comme clé
    $elements[intval($details['position'])] = [
        'name' => $name,
        'number' => $details['number'],
        'small' => $details['small'],
        'molar' => $details['molar'],
        'electrons' => $details['electrons'],
        'position' => $details['position']
    ];
}

fclose($file);

// Fonction pour générer l'HTML d'un élément
function generateElementHTML($element) {
    return "<td class='element'>
        <h4>" . htmlspecialchars($element['name']) . "</h4>
        <ul>
            <li>No " . htmlspecialchars($element['number']) . "</li>
            <li>" . htmlspecialchars($element['small']) . "</li>
            <li>" . htmlspecialchars($element['molar']) . "</li>
            <li>" . htmlspecialchars($element['electrons']) . " electron" . 
            ($element['electrons'] != '1' ? 's' : '') . "</li>
        </ul>
    </td>";
}

// Créer un nouveau fichier HTML pour enregistrer le tableau
$htmlFile = fopen("mendeleiev.html", "w");
if (!$htmlFile) {
    die("Impossible de créer le fichier mendeleiev.html");
}

// Écrire le début du fichier HTML avec des styles améliorés
fwrite($htmlFile, "<!DOCTYPE html>
<html>
<head>
    <title>Tableau de Mendeleiev</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px auto;
        }
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
            width: 80px;
            height: 80px;
            vertical-align: top;
            font-size: 10px;
        }
        .element {
            background-color: #f0f0f0;
        }
        .empty {
            background-color: white;
            border: none;
        }
        h4 {
            margin: 0 0 5px 0;
            font-size: 12px;
        }
        ul {
            margin: 0;
            padding-left: 15px;
            list-style-type: disc;
        }
        li {
            margin: 2px 0;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <h1 style='text-align: center;'>Tableau Périodique de Mendeleiev</h1>
    <table>");

// Structure correcte du tableau périodique
// Période 1: H et He aux positions 1 et 18
fwrite($htmlFile, "<tr>");
if (isset($elements[1])) {
    fwrite($htmlFile, generateElementHTML($elements[1]));
} else {
    fwrite($htmlFile, "<td class='empty'></td>");
}
// Cases vides de 2 à 17
for ($i = 2; $i <= 17; $i++) {
    fwrite($htmlFile, "<td class='empty'></td>");
}
// Hélium en position 18
if (isset($elements[2])) {
    fwrite($htmlFile, generateElementHTML($elements[2]));
} else {
    fwrite($htmlFile, "<td class='empty'></td>");
}
fwrite($htmlFile, "</tr>");

// Période 2: Li (3) à Ne (10)
fwrite($htmlFile, "<tr>");
// Li et Be (positions 3-4)
for ($i = 3; $i <= 4; $i++) {
    if (isset($elements[$i])) {
        fwrite($htmlFile, generateElementHTML($elements[$i]));
    } else {
        fwrite($htmlFile, "<td class='empty'></td>");
    }
}
// Cases vides de 5 à 14
for ($i = 5; $i <= 14; $i++) {
    fwrite($htmlFile, "<td class='empty'></td>");
}
// B à Ne (positions 13-18 de la période 2, mais numéros atomiques 5-10)
$periode2_elements = [5, 6, 7, 8, 9, 10];
foreach ($periode2_elements as $num) {
    if (isset($elements[$num])) {
        fwrite($htmlFile, generateElementHTML($elements[$num]));
    } else {
        fwrite($htmlFile, "<td class='empty'></td>");
    }
}
fwrite($htmlFile, "</tr>");

// Période 3: Na (11) à Ar (18)
fwrite($htmlFile, "<tr>");
// Na et Mg (positions 11-12)
for ($i = 11; $i <= 12; $i++) {
    if (isset($elements[$i])) {
        fwrite($htmlFile, generateElementHTML($elements[$i]));
    } else {
        fwrite($htmlFile, "<td class='empty'></td>");
    }
}
// Cases vides de 13 à 22
for ($i = 13; $i <= 22; $i++) {
    fwrite($htmlFile, "<td class='empty'></td>");
}
// Al à Ar (numéros atomiques 13-18)
for ($i = 13; $i <= 18; $i++) {
    if (isset($elements[$i])) {
        fwrite($htmlFile, generateElementHTML($elements[$i]));
    } else {
        fwrite($htmlFile, "<td class='empty'></td>");
    }
}
fwrite($htmlFile, "</tr>");

// Périodes 4-6: éléments principaux (excluant lanthanides/actinides)
// Période 4: K(19) à Kr(36)
fwrite($htmlFile, "<tr>");
for ($i = 19; $i <= 36; $i++) {
    if (isset($elements[$i])) {
        fwrite($htmlFile, generateElementHTML($elements[$i]));
    } else {
        fwrite($htmlFile, "<td class='empty'></td>");
    }
}
fwrite($htmlFile, "</tr>");

// Période 5: Rb(37) à Xe(54)
fwrite($htmlFile, "<tr>");
for ($i = 37; $i <= 54; $i++) {
    if (isset($elements[$i])) {
        fwrite($htmlFile, generateElementHTML($elements[$i]));
    } else {
        fwrite($htmlFile, "<td class='empty'></td>");
    }
}
fwrite($htmlFile, "</tr>");

// Période 6: Cs(55) à Ba(56), puis saut vers Hf(72) à Rn(86)
fwrite($htmlFile, "<tr>");
// Cs et Ba
for ($i = 55; $i <= 56; $i++) {
    if (isset($elements[$i])) {
        fwrite($htmlFile, generateElementHTML($elements[$i]));
    } else {
        fwrite($htmlFile, "<td class='empty'></td>");
    }
}
// Placeholder pour les lanthanides
fwrite($htmlFile, "<td style='background-color: #e6f3ff; border: 2px dashed #0066cc; text-align: center; font-size: 12px; vertical-align: middle;'>57-71<br>*</td>");
// Hf à Rn (72-86)
for ($i = 72; $i <= 86; $i++) {
    if (isset($elements[$i])) {
        fwrite($htmlFile, generateElementHTML($elements[$i]));
    } else {
        fwrite($htmlFile, "<td class='empty'></td>");
    }
}
fwrite($htmlFile, "</tr>");

// Période 7: Fr(87) à Ra(88), puis saut vers Rf(104) à Og(118)
fwrite($htmlFile, "<tr>");
// Fr et Ra
for ($i = 87; $i <= 88; $i++) {
    if (isset($elements[$i])) {
        fwrite($htmlFile, generateElementHTML($elements[$i]));
    } else {
        fwrite($htmlFile, "<td class='empty'></td>");
    }
}
// Placeholder pour les actinides
fwrite($htmlFile, "<td style='background-color: #ffe6e6; border: 2px dashed #cc0000; text-align: center; font-size: 12px; vertical-align: middle;'>89-103<br>**</td>");
// Rf à Og (104-118)
for ($i = 104; $i <= 118; $i++) {
    if (isset($elements[$i])) {
        fwrite($htmlFile, generateElementHTML($elements[$i]));
    } else {
        fwrite($htmlFile, "<td class='empty'></td>");
    }
}
fwrite($htmlFile, "</tr>");

// Ligne de séparation pour les lanthanides et actinides
fwrite($htmlFile, "<tr><td colspan='18' style='height: 20px; border: none; background: white;'></td></tr>");

// Lanthanides (57-71)
fwrite($htmlFile, "<tr>");
fwrite($htmlFile, "<td class='empty'></td><td class='empty'></td><td class='empty'></td>");
for ($i = 57; $i <= 71; $i++) {
    if (isset($elements[$i])) {
        fwrite($htmlFile, str_replace("class='element'", "class='element' style='background-color: #e6f3ff;'", generateElementHTML($elements[$i])));
    } else {
        fwrite($htmlFile, "<td class='empty'></td>");
    }
}
fwrite($htmlFile, "</tr>");

// Actinides (89-103)
fwrite($htmlFile, "<tr>");
fwrite($htmlFile, "<td class='empty'></td><td class='empty'></td><td class='empty'></td>");
for ($i = 89; $i <= 103; $i++) {
    if (isset($elements[$i])) {
        fwrite($htmlFile, str_replace("class='element'", "class='element' style='background-color: #ffe6e6;'", generateElementHTML($elements[$i])));
    } else {
        fwrite($htmlFile, "<td class='empty'></td>");
    }
}
fwrite($htmlFile, "</tr>");

// Fin du tableau HTML et du fichier
fwrite($htmlFile, "</table>
</body>
</html>");

// Fermer le fichier
fclose($htmlFile);

echo "Le fichier mendeleiev.html a été généré avec succès.";

?>
