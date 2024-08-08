<?php
require_once(__DIR__ . '/../../FileToFileTool.php');

class EQ3ToBinary extends FileToFileTool
{
    public function __construct()
    {
        parent::__construct('.eq3', 'application/octet-stream', '.bin', 'backend/dev_tools/converter/EQ3ToBinary.js', category: 'Converter', description: 'Converts a <a href="https://github.com/eq-3/occu/blob/825afd98b9c450bf68a0a648911f3915b671ed4e/firmware/HmIP-RFUSB/dualcopro_update_blhmip-4.4.18.eq3" target="_blank">.eq3 hex file</a> to a binary file.');
    }
}
