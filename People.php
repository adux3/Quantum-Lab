<?php 

namespace People;

use Lang\Lang as Lang;
    
class People
{
        
    private $id;
    private $firstName;
    private $lastName;

    public function __construct($id,$firstName,$lastName)
    {
        $this -> id = $id;
        $this -> firstName = $firstName;
        $this -> lastName = $lastName;
    }

    public function getPersonData()
    {
        $Lang = new Lang($this -> id);    
            
            
        return $this -> id.'.'.$this -> firstName.' '.$this -> lastName.' - '. $Lang -> getPersonLanguages()."\n";
    }
}
