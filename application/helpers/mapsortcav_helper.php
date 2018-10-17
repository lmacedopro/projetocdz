<?php

/**
 * sortRandWeight()
 * Utility ....
 */
 function sortRandWeight(array $weightedValues){
    
     $rand = mt_rand(1, (int) array_sum($weightedValues));
     
     foreach($weightedValues as $key => $value){
         $rand -= $value;
         if($rand <= 0){
             return $key;
         }
     }   
}


