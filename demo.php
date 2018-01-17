<?php

require '../class/People.php';
require '../class/Lang.php';

use People\People as People;
use Lang\Lang as Lang;

if(!isset($_SERVER['argv'][1])){
    echo 'Parameter missing!';
    die();
}

switch($_SERVER['argv'][1]){
    
    case 'list':
        
        $allPeople = People::getAllPerson();
        
        foreach($allPeople as $row){
            echo $row->getPersonData();
        }
        
    break; 
        
    case 'find':
        
        foreach(People::findPeopleByName($_SERVER['argv'][2]) as $row){
            echo $row->getPersonData();
        }
        
    break; 
        
    case 'languages':
    
        $languages = null;
        
        foreach($_SERVER['argv'] as $key => $row){
            if($key > 1){
                $languages[] = $row;
            }
        }
        
        $people = People::getPersonWithLang($languages);
        
        foreach ($people as $row){
            echo $row->getPersonData();
        }
    
    break; 
    
    case 'addPerson':
        
        $firstName = null;
        $lastName = null;
        $languages = null;
        
        foreach($_SERVER['argv'] as $key => $row){
            if($key === 2) $firstName = $row;
            if($key === 3) $lastName = $row;
            if($key > 3) $languages[] = $row;
        }
        
        People::addNewPerson($firstName,$lastName,$languages);
        
        break;
        
    case 'removePerson':
            People::deletePerson($_SERVER['argv'][2]);
        break;
    
    case 'addLanguage':
            Lang::addLanguage($_SERVER['argv'][2],$_SERVER['argv'][3]);
        break;
        
    case 'removeLanguage':
            Lang::deleteLanguage($_SERVER['argv'][2],$_SERVER['argv'][3]);
        break;
    
    default:
        echo 'Wrong command!';
        break;
}

?>