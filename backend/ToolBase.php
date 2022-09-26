<?php
require_once('Tools.php');


//Base definition of a tool
abstract class ToolBase
{
    //A map of non URI-Query compatible chars which will be replaced with something human readable.
    //Yes, we could use URI encoding but the aren't easy to read. Who the gell knows what %51 actually is.
    private static array $idStringReplaceChars = array(
        '#' => 'sharp',
        '+' => 'p'
    );

    //Escapes some URI-Reserved chars which might be used in the name of some programming languages like C++ or C#
    private static function ReplaceURIUnsafeCharsInIDPart(?string $str) : ?string
    {
        if($str === null)
            return $str;

        $ret = '';
        for ($i = 0; $i < strlen($str); $i++)
        {
            $c = $str[$i];            
            
            if(array_key_exists($c, static::$idStringReplaceChars))
                $ret .= static::$idStringReplaceChars[$c];
            else
                $ret .= $c;
        }

        return urlencode($ret);
    }

    //this will build the value for the property 'ToolBase::id'
    private static function MakeIDString(?string $language, string $name) : string
    {
        $ret = static::ReplaceURIUnsafeCharsInIDPart($name);

        if($language !== null)
            $ret = static::ReplaceURIUnsafeCharsInIDPart($language).'/'.$ret; //The character '/' is not a URI-Query reserved char as per RFC 3986. See:  https://www.rfc-editor.org/rfc/rfc3986#section-3.4

        return $ret;
    }

    private static function MakeGitHubLink(string $type) : string
    {
        $reflector = new ReflectionClass($type);

        $definingFile = $reflector->getFileName();

        $relativePathToWebRoot = substr($definingFile, strlen(tools::GetWebRoot()));

        return 'https://github.com/janwiesemann/dev.janwiesemann.de/blob/main'.$relativePathToWebRoot;
    }

    //Defines the targeted Language (i.e. C++, C, CSharp, ...). 'null' => a general tool without a specific language.
    public readonly ?string $language;

    //Name of the Tool
    public readonly string $name;

    //Unique ID, which will be used for selection and identification
    public readonly string $id;

    //A short description of this tool
    public readonly ?string $description;

    //Different links to this tool
    public readonly string $linkInternal;
    public readonly string $linkExternal;
    
    public function __construct(?string $language = null, ?string $name = null, ?string $description = null)
    {
        if($name === null) //ensure non empty name
            $name = static::class; 

        $this->name = strtolower($name);

        if($language !== null) //to lower case
            $language = strtolower($language);

        $this->language = $language;

        $this->id = static::MakeIDString($this->language, $this->name);

        $this->description = $description;

        $this->linkInternal = 'index.php?tool='.$this->id;
        $this->linkExternal = 'https://dev.janwiesemann.de/'.$this->linkInternal;
        $this->linkGitHub = static::MakeGitHubLink(static::class);
    }

    //Override this for the generation/inclusion of your code
    abstract public function Include() : void;
}