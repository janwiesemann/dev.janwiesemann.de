<?php
require_once(__DIR__ . '/../ToolBase.php');

//This basically just defines a new Type we can later use from some checks. This is used to exclude tools from the main tool list used in 'Tools::$tools'.
abstract class HiddenTool extends ToolBase
{
    public function __construct()
    {
        parent::__construct();
    }
}
