<?php
require_once('SectionTool.php');

abstract class TextToTextTool extends SectionTool
{
    protected abstract function OutputJSBody(): void;

    protected function OutputJSDefaultInputValue(): void
    {
        echo 'null';
    }

    function IncludeSectionBody(): void
    {
?>
        <table>
            <thead>
                <tr>
                    <td>
                        <h5>Input</h5>
                    </td>
                    <td>
                        <h5>Output</h5>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color: transparent !important; border: none !important;">
                    <td style="padding: 0.5em 0.25em 0px 0px !important;">
                        <textarea id="input" wrap="off" style="font-family: Consolas, monaco, monospace !important;"></textarea>
                    </td>
                    <td style="padding: 0.5em 0px 0px 0.25em !important;">
                        <textarea id="output" wrap="off" style="font-family: Consolas, monaco, monospace !important;" readonly></textarea>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Custom script section of tool -->
        <?php $this->OutputJSBody(); ?>

        <!-- Predefined Script section of 'TextToTextTool.php' -->
        <script>
            let defaultValue = <?php $this->OutputJSDefaultInputValue(); ?>;

            let jqInput = $('#input');
            let jqOutput = $('#output');

            function updateInputAndOutputTextHeights() {
                jqInput[0].style.height = 'auto';
                jqOutput[0].style.height = 'auto';

                let height = Math.max(jqInput[0].scrollHeight, jqOutput[0].scrollHeight, 250) + 5;

                jqInput[0].style.height = (height) + 'px';
                jqOutput[0].style.height = (height) + 'px';
            }

            function onInputChanged() {
                let inText = $(this).val();

                let outputElement = $('#output');

                try {
                    let res = getOutputResult(inText);

                    outputElement
                        .val(res)
                        .removeClass('outputError');
                } catch (error) {
                    outputElement
                        .val(error)
                        .addClass('outputError');
                }

                updateInputAndOutputTextHeights();
            }

            jqInput.on("input", onInputChanged)
                .val(defaultValue)
                .trigger('input');
        </script>
<?php
    }
}
