<?php
require_once(__DIR__ . '/../../SectionTool.php');

class command_line_builder extends SectionTool
{
    public function __construct()
    {
        parent::__construct(null, description: 'Annoyed by stupid command lines, hours of research and just to find out, that you\'ve missed a stupid dash? Not anymore! Be like a child! Click a few buttons and your command is done!');
    }

    function IncludeSectionBody(): void
    {
?>
        HI!
<?php
    }
}
