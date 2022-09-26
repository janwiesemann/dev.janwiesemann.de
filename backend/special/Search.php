<?php
require_once('HiddenTool.php');

//This is used if a tool was not found
class Search extends HiddenTool
{
	function Include() : void
	{
        ?>
            <section>
                <header>
                    <h1><s>I'm</s> You'r lost...</h1>
                </header>
                the tool you where looking for does not exist or you don't know how to hit keys on a keyboard
            </section>

            <section>
                <header class="major">
                    <h2>search</h2>
                </header>

                <section class="search alt">
                    <div>
                        <input type="text" id="search" placeholder="Search" />
                    </div>
                </section>

                <p><ul id="toolList"></ul></p>

                <script>
                    let listOfTools = <?php echo json_encode(Tools::GetAllTools()); ?>;

                    function onSearchInput() {
                        let search = $(this).val().toLowerCase();

                        let toolList = $('#toolList')
                            .empty();

                        listOfTools.forEach(element => {
                            let vals = [ element.language, element.name, element.id, element.description ];
                            vals.every(val => {
                                if(val != null && val.toLowerCase().includes(search)) {                            
                                    let newElement = $('<li>')
                                        .append($('<a>')
                                                .attr('href', element.linkInternal)
                                                .text(element.id))
                                        .append($('<article>')
                                                .html(element.description));

                                    toolList.append(newElement);

                                    return false;
                                }

                                return true;
                            });
                        });
                    }

                    (function() {
                        $('#search')
                                .on("input", onSearchInput)
                                .val("<?php echo $_GET["tool"] ?>")
                                .trigger('input');
                        })();
                </script>
            </section>
        <?php
    }
}