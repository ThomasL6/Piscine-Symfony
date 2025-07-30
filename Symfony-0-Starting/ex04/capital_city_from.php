<?php
$states = [
'Oregon' => 'OR',
'Alabama' => 'AL',
'New Jersey' => 'NJ',
'Colorado' => 'CO',
];
$capitals = [
'OR' => 'Salem',
'AL' => 'Montgomery',
'NJ' => 'trenton',
'KS' => 'Topeka',
];


function capital_city_from($state_name) {
    global $states, $capitals;

    if (!is_string($state_name) || !array_key_exists($state_name, $states)) {
        return "Unknown\n";
    }

    $abbr = $states[$state_name];

    return ($capitals[$abbr] ?? "Unknown") . "\n";

}

