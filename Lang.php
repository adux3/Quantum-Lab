<?php 

namespace Lang;

class Lang
{
    private $user_id;
    private $languages;

    public function __construct($user_id)
    {
        $this -> user_id = $user_id;
        $this -> importPersonLanguagesFromDB();
    }
        
    public function getPersonLanguages()
    {
        $response = '(';
            
        foreach ($this -> languages as $key => $row)
        {
            if($key !== 0) $response .= ' , ';
                
            $response .= $row;
        }
            
        return $response. ')';
    }
        
    public function checkIfKnowLang($lang)
    {
        if (in_array(strtolower($lang), array_map('strtolower', $this -> languages))) return 1;
        else return 0;
    }

    private function importPersonLanguagesFromDB()
    {
        $file = 'lang.json';
        $lang = json_decode(file_get_contents($file,true),true);
            
        $response = null;
            
        foreach($lang as $row)
        {
            if($row['id'] === $this -> user_id)
            {
                $response[] = $row['lang'];
            }
        }
            
        $this -> languages = $response;
            
        return 1;
    }
}
