<?php
require_once(__DIR__ . '/../../FileToFileTool.php');

class IntelHexToBinary extends FileToFileTool
{
    public function __construct()
    {
        parent::__construct('.hex', 'application/octet-stream', '.bin', 'backend/dev_tools/converter/IntelHexToBinary.js', category: 'Converter', description: 'Converts a <a href="https://en.wikipedia.org/wiki/Intel_HEX" target="_blank">Intel .hex file</a> to a binary file.');
    }
}
