<?php

class Tool
{
    public $name;
    public $language;
    public $path;
    public $id;
    
    public function __construct($language, $name, $path)
    {
        if($language !== null) {
            $this->language = strtolower($language);
            $this->id = $this->language;
        }

        if($name !== null) {
            $this->name = strtolower($name);
            $this->id = $this->id.'/'.$this->name;
        }

        $this->path = $path;
    }

    public function IncludeTool($allTools)
    {
        include($this->path);
    }
}

function GetAllTools() {
    $ret = array();

    $languageDirs = scandir('dev_tools');
    foreach($languageDirs as $langDir)
    {
        if($langDir === '.' || $langDir === '..') {
            continue;
        }

        $dir = 'dev_tools/'.$langDir;
        if(!is_dir($dir)) {
            continue;
        }

        $langFiles = scandir($dir);
        foreach($langFiles as $file)
        {
            if($file === '.' || $file === '..') {
                continue;
            }

            $path = $dir.'/'.$file;

            if(!is_file($path)) {
                continue;
            }

            if(strpos($file, '.php')) {
                $file = substr($file, 0, -4);
            }

            $tool = new Tool($langDir, $file, $path);
            array_push($ret, $tool);
        }
    }

    return $ret;
}

function GetCurrentTool($allTools)
{
    if(empty($_GET["id"])) {
        return new Tool(null, null, 'home.php');
    }
    $id = $_GET["id"];

    foreach($allTools as $tool)
    {
        if(strcmp($id, $tool->id) == 0) {
            return $tool;
        }
    }
    
    return new Tool(null, null, 'search.php');
}

?>