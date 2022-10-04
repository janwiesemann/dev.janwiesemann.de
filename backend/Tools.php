<?php
require_once('ToolBase.php');

require_once(__DIR__ . '/special/HiddenTool.php');
require_once(__DIR__ . '/special/Home.php');
require_once(__DIR__ . '/special/Search.php');

//This class allow you to access all available tools.
class Tools
{
    private static ?array $tools = null;
    private static ?ToolBase $currentTool = null;

    private static ?string $webRoot = null;

    //this will load all .php files from a given directory and its subdirectories
    private static function LoadToolFilesFromDirectory(string $dir): void
    {
        $allFiles = scandir($dir);
        foreach ($allFiles as $file)
        {
            if ($file === '.' || $file  === '..')
                continue;

            $fullPath = $dir . '/' . $file;

            if (is_dir($fullPath))
                Tools::LoadToolFilesFromDirectory($fullPath);
            else if (is_file($fullPath) && str_ends_with($fullPath, '.php'))
                include_once($fullPath);
        }
    }

    //Returns a list of all available tools
    public static function GetAllTools(): array
    {
        if (Tools::$tools === null)
        {
            Tools::LoadToolFilesFromDirectory(__DIR__ . '/dev_tools');

            Tools::$tools = array();
            foreach (get_declared_classes() as $type)
            {
                if (!is_subclass_of($type, ToolBase::class)) //Type which do nit inherit from ToolBase
                    continue;

                if (is_subclass_of($type, HiddenTool::class)) //Special tool, which are hidden from the main tool list.
                    continue;

                $rc = new ReflectionClass($type);
                if ($rc->isAbstract())
                    continue;

                array_push(Tools::$tools, new $type);
            }
        }

        return Tools::$tools;
    }

    //returns the current/selected tool
    public static function GetCurrentTool(): ToolBase
    {
        if (Tools::$currentTool === null)
        {
            if (isset($_GET['tool']) && !empty($_GET['tool']))
            {
                $searchID = strtolower($_GET['tool']);
                foreach (Tools::GetAllTools() as $tool)
                {
                    if ($tool->id == $searchID)
                    {
                        //Found a tool
                        Tools::$currentTool = $tool;

                        break;
                    }
                }

                if (Tools::$currentTool === null)  //If a name was given but no tool with this ID was found
                    Tools::$currentTool = new Search();
            }
            else //Fallback if no tool is specified using URI parameter 'id'
                Tools::$currentTool = new Home();
        }

        return Tools::$currentTool;
    }

    public static function SetWebRoot(string $webRoot)
    {
        Tools::$webRoot = $webRoot;
    }

    public static function GetWebRoot(): string
    {
        return Tools::$webRoot;
    }
}
