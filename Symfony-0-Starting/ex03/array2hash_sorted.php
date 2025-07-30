<?php
function array2hash_sorted($arrays) {
    $hash = array();
    for ($i = 0; $i < count($arrays); $i++){
        if(count($arrays[$i]) == 2) 
            $hash[$arrays[$i][1]] = $arrays[$i][0];
        else 
        return null;        
    }
    if (count($hash) == 0) {
        return null;
    }
    $sorted_hash = array();
    rsort($sorted_hash);
    return ($hash);
}
?>