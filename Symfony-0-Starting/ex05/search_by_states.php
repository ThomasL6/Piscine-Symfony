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

function search_by_states($state_name) {
    global $states, $capitals;

    $states_flipped = array_flip($states);

    $state_name = trim($state_name);
    foreach (explode(',', $state_name) as $name) {
        $name = trim($name);

        if (array_key_exists($name, $states)) {
            $abbr = $states[$name];
            if (array_key_exists($abbr, $capitals))
                echo "{$capitals[$abbr]} is the capital of {$name}.\n";
            else
                echo "{$name} ({$abbr}) is neither a capital nor a state.\n";
        }
        elseif (in_array($name, $capitals)) {
            $abbr = array_search($name, $capitals);
            if (array_key_exists($abbr, $states_flipped)) {
                $state = $states_flipped[$abbr];
                echo "{$name} is the capital of {$state}.\n";
            } 
            else
                echo "{$name} is neither a capital nor a state.\n";
        }
        else
            echo "{$name} is neither a capital nor a state.\n";
    }
}

