<?php
function array2hash($arrays) {
    $hash = array();
    for ($i = 0; $i < count($arrays); $i++){
        if(count($arrays[$i]) == 2) 
            $hash[$arrays[$i][1]] = $arrays[$i][0];
        else 
            return null;        
    }
    return $hash;
}
?>