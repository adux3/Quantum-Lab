<?php 

namespace Lang;

class Lang
{
    private $userId;
    private $languages;

    public function __construct($userId)
    {
        $this -> userId = $userId;
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
        $file = '../json/lang.json';
        $lang = json_decode(file_get_contents($file,true),true);
            
        $response = null;
            
        foreach($lang as $row)
        {
            if($row['id'] === $this -> userId)
            {
                $response[] = $row['lang'];
            }
        }
            
        $this -> languages = $response;
            
        return 1;
    }
    
    //STATIC FOR MANAGEMENT
        
    public static function addLanguage($lang, $id)
    {
        if($lang == '')
        {
            echo 'Missing parameter - language!';
            return 0;
        }
            
        try
        {
            $file = '../json/lang.json';
            $languages = json_decode(file_get_contents($file,true),true);

            array_push($languages,['id' => (int)$id, 'lang' => strtolower($lang)]);

            file_put_contents($file, json_encode($languages),FILE_USE_INCLUDE_PATH);

            echo 'Success!';
                
        } 
        catch (Exception $ex) 
        {
            echo 'Failed';
        }
    }
        
    public static function deleteLanguage($deleteLanguage, $id)
    {
        $file = '../json/lang.json';
        $languages = json_decode(file_get_contents($file,true),true);
        $deleted = false;
            
        foreach($languages as $key => $language)
        {
            if($language['lang'] == $deleteLanguage && $language['id'] == (int)$id) 
            {
                unset($languages[$key]);
                $deleted = true;
            }
        }
            
        file_put_contents($file, json_encode($languages),FILE_USE_INCLUDE_PATH);
            
        if($deleted) 
        {
            echo 'Success!';
        }
        else
        {
            echo 'Nothing found for remove!';
        }
    }
}
