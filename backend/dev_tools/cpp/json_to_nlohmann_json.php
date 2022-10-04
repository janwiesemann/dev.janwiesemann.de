<?php
require_once(__DIR__ . '/../../TextToTextTool.php');

class json_to_nlohmann_json extends TextToTextTool
{
    public function __construct()
    {
        parent::__construct('C++', description: 'This tool can convert a plain JSON-Object to a <a href="https://github.com/nlohmann/json" target="_blank">nlohmann::json</a> C++ initializer_list.');
    }

    function GetJSDefaultInputValues(): mixed
    {
        return array(
            'default' => array(
                'string' => 'abc',
                'int' => 123,
                'float' => 123.456,
                'bool' => true,
                'null' => null,
                'object' => array(
                    'propA' => 'value',
                    'propB' => 123,
                    'propC' => false,
                    'propD' => array(1, 2, 3)
                ),
                'array' => array(
                    'This is a string',
                    1,
                    array(
                        'prop' => 'value'
                    ),
                    array(4, 5, 6)
                )
            )
        );
    }

    function OutputJSBody(): void
    {
?>
        <script>
            function getIndents(level) {
                let ret = "";

                for (let i = 0; i < level; i++) {
                    ret += '    ';
                }

                return ret;
            }

            function appendArray(indentLevel, arr, parent) {
                let ret = 'nlohmann::json::array(\n';
                ret += getIndents(indentLevel);
                ret += '{\n';

                indentLevel++;
                let rows = [];
                arr.forEach(element => {
                    let row = "";
                    if (typeof element !== 'object' || Array.isArray(element)) {
                        row += getIndents(indentLevel);
                    }
                    row += append(indentLevel, element, arr);

                    rows.push(row);
                });

                ret += rows.join(',\n');
                ret += '\n';

                indentLevel--;
                ret += getIndents(indentLevel);
                ret += '})';

                if (parent !== null && !Array.isArray(parent)) {
                    ret += '\n';
                }

                return ret;
            }

            function appendObject(indentLevel, obj, parent) {
                let ret = getIndents(indentLevel);
                ret += '{\n';

                let rows = [];
                indentLevel++;
                for (const [key, value] of Object.entries(obj)) {
                    let row = getIndents(indentLevel);
                    row += '{ "';
                    row += key.toString();
                    row += '", ';

                    if (value != null && typeof value === 'object' && !Array.isArray(value)) {
                        row += '\n';
                    }

                    row += append(indentLevel + 1, value, obj);

                    if (value != null && typeof value === 'object') {
                        row += getIndents(indentLevel);
                    } else {
                        row += ' ';
                    }
                    row += '}';

                    rows.push(row);
                }
                indentLevel--

                ret += rows.join(',\n');

                ret += '\n'
                ret += getIndents(indentLevel);
                ret += '}';

                if (!Array.isArray(parent)) {
                    ret += '\n';
                }

                return ret;
            }

            function append(indentLevel, node, parent) {
                if (node === null || node === undefined) {
                    return "nullptr";
                }

                switch (typeof node) {
                    case 'object':
                        if (Array.isArray(node)) {
                            return appendArray(indentLevel, node, parent);
                        } else {
                            return appendObject(indentLevel, node, parent)
                        }

                        case 'string':
                            return '"' + node + '"';

                        default:
                            return node.toString();
                }
            }

            function getOutputResult(inText) {
                let j = JSON.parse(inText);

                let str = append(0, j, null);
                return str;
            }
        </script>
<?php
    }
}
