<?php
require_once('ToolBase.php');

//A tool, which includes a section with a header.
//this should be used as a base class to add new tools
abstract class SectionTool extends ToolBase
{
    protected abstract function IncludeSectionBody() : void;

    function Include() : void
	{
        ?>
            <section>
                <header class="major">
                    <h2><?php echo $this->name; ?></h2>
                </header>

                <?php
                    if($this->description !== null)
                        echo '<p>'.$this->description.'</p>';                
                
                    $this->IncludeSectionBody();
                ?>        
            </section>
        <?php
    }
}