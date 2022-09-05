<style>
    #mainElement {
        display: flex;
        flex-flow: row;
        height: auto;
    }

    #input, #output {
        flex: 50%;
        vertical-align: top;
        resize: none;
        overflow: hidden;
    }

    .outputError {
        color: #f56a6a;
    }
</style>

<p>
    This tool can convert a plain JSON-Object to a <a href="https://github.com/nlohmann/json" target="_blank">nlohmann::json</a> C++ initializer_list.
    Just paste the code on the left and examine the result on the right side.
</p>

<div id="mainElement">
    <textarea id="input" wrap="off"></textarea>
    <textarea id="output" wrap="off" readonly></textarea>
</div>
</section>

<script>
    function getIndents(level) {
    let ret = "";

    for(let i = 0; i < level; i++) {
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
        if(typeof element !== 'object' || Array.isArray(element)) {
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

    if(parent !== null && !Array.isArray(parent)) {
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

        if(value != null && typeof value === 'object' && !Array.isArray(value)) {
            row += '\n';
        }

        row += append(indentLevel + 1, value, obj);

        if(value != null && typeof value === 'object') {
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

    if(!Array.isArray(parent)) {
        ret += '\n';
    }

    return ret;
}

function append(indentLevel, node, parent) {
    if(node === null || node === undefined) {
        return "nullptr";
    }

    switch(typeof node)
    {
        case 'object':
            if(Array.isArray(node)) {
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

function onInputChanged() {
    let inText = $(this).val();

    let outputElement = $('#output');

    try {
        let j = JSON.parse(inText);

        let str = append(0, j, null);

        outputElement
            .val(str)
            .removeClass('outputError');
    }
    catch(error) {
        outputElement
            .val(error)
            .addClass('outputError');
    }

    outputElement = outputElement[0];

    outputElement.style.height = 'auto';
    this.style.height = 'auto';

    let height = Math.max(outputElement.scrollHeight, this.scrollHeight, 250);

    outputElement.style.height = (height) + 'px';
    this.style.height = (height) + 'px';
}

(function() {
   $('#input')
        .on("input", onInputChanged)
        .val(JSON.stringify( //Default Preview JSON
            {
                string: "abc",
                int: 123,
                float: 123.456,
                object: {
                    propA: "valA",
                    propB: 123,
                    propC: true,
                    propD: [ 1, 2, 3 ]
                },
                nodeArray: [
                    "This is a string!",
                    1,
                    {
                        prop: "This is a random value!"
                    },
                    [
                        "I like potato's!"
                    ] 
                ]
            }, null, 4
        ))
        .trigger('input');
})();
</script>