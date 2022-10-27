<?php
require_once(__DIR__ . '/../../SectionTool.php');

class does_it_suck extends SectionTool
{
    public function __construct()
    {
        parent::__construct('Java', description: 'This will finally answer one of the most asked questions in the entire universe.');
    }

    function IncludeSectionBody(): void
    {
?>
        <h1>Yes!</h1>
<?php
    }
}
