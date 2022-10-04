<?php
require_once('SectionTool.php');

abstract class TextToTextTool extends SectionTool
{
    protected abstract function OutputJSBody(): void;

    protected function GetJSDefaultInputValues(): mixed
    {
        return null;
    }

    function IncludeSectionBody(): void
    {
?>
        <h4>example values</h4>
        <div id="exampleButtonsContainer"></div>

        <table>
            <thead>
                <tr>
                    <td>
                        <h4>Input</h4>
                    </td>
                    <td>
                        <h4>Output</h4>
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
            let defaultValues = <?php
                                $data = $this->GetJSDefaultInputValues();
                                if (!is_null($data) && !is_array($data)) //if data has any value and this value isn't a array, convert it to a array with just one element.
                                    $data = array($data);

                                echo json_encode($data);
                                ?>;

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

            function onExampleButtonClick() {
                let value = this.exampleValue;

                if (typeof value === 'object')
                    value = JSON.stringify(value, null, 4);

                jqInput
                    .val(value)
                    .trigger('input');

                let id = $(this).val();
                window.location.hash = id;
            }

            let jqExampleButtonsContainer = $('#exampleButtonsContainer');
            let jqDefaultExampleButton = null;
            for (const [key, value] of Object.entries(defaultValues)) {
                let button = $('<input>')
                    .attr('type', 'button')
                    .val(key)
                    .click(onExampleButtonClick);

                button[0].exampleValue = value;

                if (jqDefaultExampleButton === null || window.location.hash === '#' + encodeURI(key))
                    jqDefaultExampleButton = button;

                jqExampleButtonsContainer.append(button);
            }

            jqInput.on('input', onInputChanged);

            if (jqDefaultExampleButton !== null)
                jqDefaultExampleButton.trigger('click');
        </script>
<?php
    }
}
