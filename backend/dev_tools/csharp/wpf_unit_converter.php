<?php
require_once(__DIR__ . '/../../SectionTool.php');

class wpf_unit_converter extends SectionTool
{
    public function __construct()
    {
        parent::__construct('C#-WPF', description: 'Convert from and to WPF units.');

        //https://learn.microsoft.com/en-us/dotnet/api/system.windows.frameworkelement.width?view=windowsdesktop-7.0&redirectedfrom=MSDN#xaml-values
    }

    function OutputDescription(): void
    {
        parent::OutputDescription();

?>
        <p>
        <blockquote>
            This value is interpreted as a device-independent unit (1/96th inch) measurement. Strings need not explicitly include decimal points. For instance a value of 1 is acceptable.<br /><br />
            <i>See: <a href="https://learn.microsoft.com/en-us/dotnet/api/system.windows.frameworkelement.width#xaml-values" target="_blank">https://learn.microsoft.com/en-us/dotnet/api/system.windows.frameworkelement.width#xaml-values</a></i>
        </blockquote>
        This means:
        <pre><code>96 units = 1 inch = 2.54cm</code></pre>
        </p>
    <?php
    }

    function IncludeSectionBody(): void
    {
    ?>
        <style>
            .column {
                float: left;
                width: 33.33%;
            }

            .row:after {
                content: "";
                display: table;
                clear: both;
            }

            .column>input {
                width: 100%;
            }
        </style>

        <div class="row">
            <div class="column">WPF-Unit</div>
            <div class="column">Inch (freedom units)</div>
            <div class="column">Metric (cm; the only not stupid unit)</div>
        </div>

        <div class="row">
            <div class="column"><input type="text" id="inputWPFUnit" /></div>
            <div class="column"><input type="text" id="inputInch" /></div>
            <div class="column"><input type="text" id="inputMetric" /></div>
        </div>

        <script>
            let inputWPFUnit = $('#inputWPFUnit');
            let inputInch = $('#inputInch');
            let inputMetric = $('#inputMetric');

            function onInputChanged() {
                let sourceValue = Number.parseFloat($(this).val());
                if (Number.isNaN(sourceValue))
                    return;

                if (this == inputWPFUnit[0]) {
                    inputInch.val(1 / 96 * sourceValue);
                    inputMetric.val(2.54 / 96 * sourceValue);
                } else if (this == inputInch[0]) {
                    inputWPFUnit.val(sourceValue * 96);
                    inputMetric.val(sourceValue * 2.54);
                } else if (this == inputMetric[0]) {
                    inputWPFUnit.val(96 / 2.54 * sourceValue);
                    inputInch.val(sourceValue / 2.54);
                }
            }

            inputWPFUnit.on('input', onInputChanged);
            inputInch.on('input', onInputChanged);
            inputMetric.on('input', onInputChanged);

            inputWPFUnit.val(48);
            inputWPFUnit.trigger('input');
        </script>
<?php
    }
}
