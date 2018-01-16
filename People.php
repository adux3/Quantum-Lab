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
    
    private static function getNewID()
    {
        $file = 'peopleAI.json';
        $id = json_decode(file_get_contents($file,true),true)['new-id'];
            
        return $id;
    }
        
    private static function incrementNewID()
    {
        $newID = People::getNewID() + 1;
            
        $json = '{"new-id": '.$newID.'}';
            
        $file = 'peopleAI.json';
            
        file_put_contents($file, $json,FILE_USE_INCLUDE_PATH);
    }
        
    //STATIC FOR MANAGEMENT
        
    public static function getAllPerson()
    {
        $file = 'people.json';
        $people = json_decode(file_get_contents($file,true),true);
        $response = null;
            
        foreach($people as $person)
        {
            $response[] = new People($person['id'],$person['imie'], $person['nazwisko']);
        }
            
        return $response;
    }
        
    public static function getPersonWithLang($languages)
    {
        $people = People::getAllPerson();
            
        foreach($people as $person)
        {
            $filtr_ok = true;
               
            foreach($languages as $row)
            {
                $Lang = new Lang($person -> id);
                if(!$Lang -> checkIfKnowLang($row)) $filtr_ok = false;
            }
               
            if($filtr_ok) 
            {
                $response[] = $person;
            }
        }
            
        return $response;
    }
        
    public static function findPeopleByName($find)
    {
        $people = People::getAllPerson();
            
        $response = null;
            
        foreach($people as $person)
        {
            $name = $person -> firstName. ' '. $person->lastName;
            if (strpos($name, $find) !== false) 
            {
                $response[] = $person;
            }
        }
        return $response;
    }
        
    public static function addNewPerson($firstName, $lastName , $languages)
    {
        $file = "people.json";
        $people = json_decode(file_get_contents($file,true),true);
            
        $new_id = People::getNewID();
            
        array_push($people,['id' => $new_id, 'imie' => $firstName , 'nazwisko' => $lastName]);
            
        file_put_contents($file, json_encode($people),FILE_USE_INCLUDE_PATH);
            
        $file2 = 'lang.json';
        $langList = json_decode(file_get_contents($file2,true),true);
        foreach($languages as $lang)
        {
            array_push($langList,['id' => $new_id, 'lang' => strtolower($lang)]);
        }
            
            
        file_put_contents($file2, json_encode($langList),FILE_USE_INCLUDE_PATH);
            
        People::incrementNewID();
            
        return 1;
    }
        
    public static function deletePerson($id)
    {
        $file = "people.json";
        $people = json_decode(file_get_contents($file,true),true);
            
        foreach($people as $key => $person)
        {
            if($person['id'] == $id)
            {
                unset($people[$key]);
            }
        }
            
        file_put_contents($file, json_encode($people),FILE_USE_INCLUDE_PATH);
            
        $file2 = 'lang.json';
        $languages = json_decode(file_get_contents($file2,true),true);
            
        foreach($languages as $key => $lang)
        {
            if($lang['id'] == $id)
            {
                unset($lang[$key]);
            }
        }
            
        file_put_contents($file2, json_encode($languages),FILE_USE_INCLUDE_PATH);
    }
}
