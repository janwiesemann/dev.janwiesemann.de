# dev.JANWIESEMANN.de
is a collection of some small and useful tool to ease your development workflow.

# Embedding / API
A list of all tools and all links can be retrieved by querying `https://dev.janwiesemann.de/index.php?json`

# Contribute /How to

[TL;DR](#implementation--example)

## Privacy
**I don't like companies who want to steal all my personal details and please respect and follow this schema!**

1. avoid server side code. If possible inputs should never be transmitted to the server! (i.e. to dev.janwiesemann.de via HTTP POST or HTML form)
2. avoid data collecting services like [Google Fonts](https://policies.google.com/technologies/cookies) or [Google Hosted Libraries](https://developers.google.com/speed/libraries/terms)
3. I like cookies but the EU's stupid cookie message is annoying. This is why you should't use any cookies! If you need cookies, limit them to a specific tool and implement a cookie waring as a **optional opt-in**!

## Tool naming
Please try to match the name of you a new tool as closely ad possible to existing tools.

1. write everything in lower case
2. replace white spaces with `'_'`
3. replace special chars (like filesystem, uri or html reserved) with something non reserved
4. replace multiple `'_' + '_'` with a single `'_'`
5. names should describe what a tool does

## Styling
Since this page uses a free template by HTML5 up, place respect his work an do not butcher his template. Hey already defined styles for most HTML elements and a full example can be found at <https://html5up.net/uploads/demos/editorial/elements.html>.

## ~~Mobile first~~
No mobile first is required. These are tools designed for developers. I don't know anyone who develops using a phone.

## Browser support
As for browser support... Well... you know how it is. Standard are defined to ease your life. Browser standard are a mess. Please don't waste your time with a large number of compatible browsers. As long as the most common ones are supported. This means, Chromium based, Firefox or Safari (due to me being a apple boy and mobile devices). Don't bother with Internet Explorer. If you are a developer you should know why you shouldn't use it. If your company forces you to use IE, get a new job!

## Underlying software-stack
This page will be running on [nginx](https://nginx.org/) and [php-fqm @ php 8.1](https://php-fpm.org).

## Coding style

Please do us all a favor and when ever possible, use strong types! I don't want to guess what a `$nodeOfATreeOfASomething` actually represents!

## Base types
There are multiple base types for a new tool defined. Typically you want to use the `SectionTool` as a base.

> Hint: All inheriting types need to call the constructor of `ToolBase` or its parent!

### ToolBase (`backend/ToolBase.php`)
This the base of all tools. Use this, if you need a lot of customization.

```php
//Call this in your new tools constructor using parent::__construct();
public function __construct
    (
        /*
            This defines the targeted language of a tool.
            This can be something like 'C++' or 'C#'.
            Use 'null', if it's a general tool and does not target a specific language.
        */
        ?string $language = null,

        /*
            This defines the name of your tool.
            If this value is 'null', the name of your class will be used.
        */
        ?string $name = null,

        /*
            A short description of your tool.
            This can be HTML.
        */
        ?string $description = null
    )
```

```php
//Override/implement this as your main tool body.
//This will be called between the page header ('/dev_tools/cpp/json_to_nlohmann_jsonthe ART of being lazy*') and it's footer ('open source', 'the ART of being lazy*')
function Include() : void
{
    /* This will be called to include your tool */
}
```

### SectionTool (`backend/SectionTool.php`; parent: ToolBase)
This is the default base for most tools. It will display a new section/header on the page. This will also include the description.

```php
//Override/implement this as your main tool body.
//This will generate the Body of your section/tool
function IncludeSectionBody() : void
{
    /* This will be called to include your tools body */
}
```

### TextToTextTool (`backend/TextToTextTool.php`); parent: SectionTool)
This tool will display two textareas. The left one is the input and the right one is the output. This can be used for from 'X' to 'Y' like tools.

```php
//This should output the conversion code.
function OutputJSBody() : void
{
    function OutputJSBody() : void
    {
        ?>
            <script>
                //This JavaScript function will be called as soon as the user types something in the input.
                //It should return a string. This string will be used as the result.
                //If there is a error in the input, throw a exception. The exception message will be used as the error message.
                function getOutputResult(inText) {
                    return "output";
                }
            </script>
        <?php
    }
}

//Override/implement this to set a default value for the input.
//The output has to be valid JS!
function OutputJSDefaultInputValue() : void //Optional override
{
    /* echo '"xvz"'; */
}
```

### SpecialTool (`backend/special/HiddenTool.php`; parent: ToolBase)
Used internally and should not be used as a base.

## Including a new tool
This on is easy. You don't need to add anything. Just create a new .php-file and implement a fitting [base class](#base-types).

## Implementation / Example

1. **Create a new source file** \
    Create a new php-file in the corresponding directory. This will be something like
    ```sh
    backend/dev_tools/cpp/json_to_nlohmann_json.php
    ```
2.  **Add the basic code**
    > Hint: There are multiple base types available!

    ```php
    <?php
    require_once(__DIR__.'/../../SectionTool.php'); //Modify if your tool is not placed inside 'backend/dev_tools/lang}/{file}'

    //This is the name of your main class.
    //If you do not specify a name inside parent::__construct();, this class name will be used as the name of your tool.
    class json_to_nlohmann_json extends SectionTool
    {
        public function __construct()
        {
            //Set basic tool Information.
            parent::__construct('C++', description: 'This tool can convert a plain JSON-Object to a <a href="https://github.com/nlohmann/json" target="_blank">nlohmann::json</a> C++ initializer_list. Just paste the code on the left and examine the result on the right side.');
        }

        //This will be called, if your tool should be included
        function IncludeSectionBody() : void
        {
            ?>
                <!-- Add your HTML-Code here -->
            <?php
        }
    }
    ?>
    ```

3. **Testing** \
    Make sure your tool work in the [server environment](#underlying-software-stack)!

4. **Finish** \
    Create a pull request and add some credits to you new tool.