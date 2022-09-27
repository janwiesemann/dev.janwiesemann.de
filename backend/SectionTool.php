<?php
require_once('ToolBase.php');

//A tool, which includes a section with a header.
//this should be used as a base class to add new tools
abstract class SectionTool extends ToolBase
{
    protected abstract function IncludeSectionBody() : void;

    protected function OutputDescription() : void
    {
        if($this->description !== null)
            echo '<p>'.$this->description.'</p>';     
    }

    function Include() : void
	{
        ?>
            <section>
                <header class="major">
                    <h2><?php echo $this->name; ?></h2>
                </header>

                <?php
                    $this->OutputDescription();
                
                    $this->IncludeSectionBody();
                ?>        
            </section>
        <?php
    }
}