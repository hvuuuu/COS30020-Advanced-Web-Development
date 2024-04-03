<?php 
    class Monster {                                 // start the Monster class 
        public $num_of_eyes;                        // properties 
        public $colour;
    
        function __construct($num, $col) {          // constructor 
            $this->num_of_eyes = $num;              // initialise number of eyes 
            $this->colour = $col;                   // initialise colour 
        }

        function describe () { 
            $ans = "The " . $this->colour . " monster has " . $this->num_of_eyes . " eyes.";  
            return $ans; 
        } 
    }
?> 