<?php
require_once('SectionTool.php');

abstract class FileToFileTool extends SectionTool
{
    public readonly string $inputAcceptedMimeTypes;
    public readonly string $resultMimeType;
    public readonly string $resultFileExtension;
    public readonly string $converterScript;

    public function __construct(string $inputAcceptedMimeTypes, string $resultMimeType, string $resultFileExtension, string $converterScript, ?string $category = null, ?string $name = null, ?bool $isGeneralTool = null, ?string $description = null)
    {
        parent::__construct($category, $name, $isGeneralTool, $description);

        $this->inputAcceptedMimeTypes = $inputAcceptedMimeTypes;
        $this->resultMimeType = $resultMimeType;
        $this->resultFileExtension = $resultFileExtension;
        $this->converterScript = $converterScript;
    }

    protected function OutputJSCallReadFunction(): void
    {
?>
        <script>
            function callRead(reader, file) {
                reader.readAsText(file);
            }
        </script>
    <?php
    }

    function IncludeSectionBody(): void
    {
    ?>
        <input id="fileSelectButton" type="button" style="width:100%" value="Select file" />
        <input id="fileInput" style="display: none;" type="file" value="Load from file" accept="<?php echo $this->inputAcceptedMimeTypes; ?>"></input>

        <progress id="progress" style="width: 100%;"></progress>

        <a id="fileDownload" download="file.bin" style="width: 100%; text-decoration: none !important; border-bottom: none;"><input id="fileDownloadButton" type="button" style="width:100%" value="Download file" /> </a>

        <!-- Custom Script section -->
        <?php $this->OutputJSCallReadFunction() ?>

        <!-- Predefined Script section of 'FileToFileTool.php' -->
        <script>
            let jqFileSelectButton = $('#fileSelectButton');
            let jqFileInput = $('#fileInput');
            let jqFileDownload = $('#fileDownload').hide();
            let jqProgress = $('progress').hide();

            let conversionWorker = null;
            let resultURI = null;

            jqFileSelectButton.on('click', () => {
                jqFileInput.click();
            });

            jqFileInput.on('change', (event) => {
                if (event.target.files.length <= 0)
                    return;

                jqFileDownload.hide();

                const file = event.target.files[0];

                let newFileName = file.name;
                let extPos = newFileName.lastIndexOf('.');
                if (extPos >= 0)
                    newFileName = newFileName.substr(0, extPos) + '<?php echo $this->resultFileExtension; ?>';

                const reader = new FileReader();
                reader.addEventListener('progress', (event) => {
                    jqProgress.show()
                        .val(event.loaded)
                        .attr('max', event.total);
                });
                reader.addEventListener('load', async (event) => {
                    jqProgress.val(null)
                        .attr('max', null);

                    if (conversionWorker != null)
                        conversionWorker.terminate();

                    conversionWorker = new Worker('<?php echo $this->converterScript; ?>');
                    conversionWorker.onmessage = (event) => {
                        if (event.data.type == 'progress') {
                            jqProgress.show()
                                .val(event.data.value)
                                .attr('max', event.data.max);
                        } else if (event.data instanceof Blob) {

                            if (resultURI != null)
                                URL.revokeObjectURL(resultURI)

                            resultURI = URL.createObjectURL(event.data)

                            jqProgress.hide();
                            jqFileInput.val(null);
                            jqFileDownload.show()
                                .attr('download', newFileName)
                                .attr('href', resultURI);
                        }
                    };

                    conversionWorker.postMessage({
                        type: 'convert',
                        data: event.target.result,
                        newFileName: newFileName
                    });
                });

                callRead(reader, file);
            });
        </script>
<?php
    }
}
