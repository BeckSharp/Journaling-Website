<?php

//Class designed to create an object of a HTML page
class HTMLPage {
    //OBJECT FIELDS
    private $_dir_css = "";         //Store the directory for CSS
    private $_dir_js = "";          //Store the directory for JavaScript
    private $_dir_img = "";         //Store the directory for images
    private $_dir_fonts = "";       //Store the directory for fonts
    private $_dir_data  = "";       //Store the directory for data
    
    private $_arr_js = [];          //Store an array of JavaScript
    private $_arr_css = [];         //Store an array of CSS files
    private $_arr_meta = [];        //Store an associative array of meta data

    private $_head_title = "";      //Store the page title
    private $_head_otherhtml = "";  //Store the header HTML
    private $_head_favicon = "";    //Store the Favicon
    
    private $_body_content = "";    //Store the body content
  
    //CONSTRUCTORS
    function __construct($title) {
        $this->_head_title = $title;
    }
    
    //SETTERS
    public function addScriptFile($scriptfile) {
        $this->_arr_js[] = $scriptfile;
    }
    
    public function addCSSFile($cssfile) {
        $this->_arr_css[] = $cssfile;
    }
    
    public function addMetaElement($metakey, $metavalue) {
        $this->_arr_meta[$metakey] = $metavalue;
    }
    
    public function setPageTitle($title) {
        $this->_head_title = $title;
    }
    
    public function setCustomHead($headhtml) {
        $this->_head_otherhtml = $headhtml;
    }
    
    public function setDirCSS($csspath) {
        $this->_dir_css = $csspath;
    }
    
    public function setDirJS($jspath) {
        $this->_dir_js = $jspath;
    }
    
    public function setDirImages($imgpath) {
        $this->_dir_img = $imgpath;
    }
    
    public function setDirFonts($fontpath) {
        $this->_dir_fonts = $fontpath;
    }
    
    public function setDirData($datapath) {
        $this->_dir_data = $datapath;
    }
    
    public function setBodyContent($bodycontent) {
        $this->_body_content = $bodycontent;
    }
    
    public function setFavIcon($iconfile) {
        $this->_head_favicon = $iconfile;
    }
    
    //GETTERS  
    public function getScriptFileArray($withpath = false) {
        if($withpath)
        {
            return $this->toURLs($this->_arr_js, $this->_dir_js);
        }
        return $this->_arr_js;
    }
    
    public function getCSSFileArray($withpath = false) {
        if($withpath)
        {
            return $this->toURLs($this->_arr_css, $this->_dir_css);
        }
        return $this->_arr_css;
    }
    
    public function getPageTitle() {
        return $this->_head_title;
    }
    
    public function getDirCSS() {
        return $this->_dir_css;
    }
    
    public function getDirJS() {
        return $this->_dir_js;
    }
    
    public function getDirImages() {
        return $this->_dir_img;
    }
    
    public function getDirFonts() {
        return $this->_dir_fonts;
    }
    
    public function getDirData() {
        return $this->_dir_data;
    }
    
    public function getBodyContent() {
        return $this->_body_content;
    }
        
    //PUBLIC FUNCTIONS
    public function renderPage() {
        echo $this->createPage();
    }
    
    public function createPage() {
        $markup = <<<HTML
<!DOCTYPE html>
<html lang="en">
<!--HEAD ELEMENT -->
{$this->createHTML_Head()}
<!--BODY ELEMENT -->
{$this->createHTML_Body()}
</html>
HTML;
        return $markup;
    }
  
    //Setting all relevant file paths
    public function setMediaDirectory($css, $js, $fonts, $img, $data) {
        $this->setDirCSS($css);
        $this->setDirJS($js);
        $this->setDirFonts($fonts);
        $this->setDirImages($img);
        $this->setDirData($data);
    }

    //HEAD CREATION FUNCTIONS
    private function createHTML_Head() {
        $head = <<<HEAD
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {$this->createHTML_Meta()}
    {$this->createHTML_FavIcon()}
    <title>{$this->_head_title}</title>
    <!-- Include External CSS -->
    {$this->createHTML_CSS()}
</head>
HEAD;
        return $head;
    }
    
    private function createHTML_Meta() {
        $html = "";
        foreach($this->_arr_meta as $key => $value)
        {
            $markup = <<<META
<meta name="{$key}" value="{$value}">       
META;
            $html .= $markup;
        }
        return $html;
    }
    
    private function createHTML_FavIcon() {
        $html = "";
        if(!empty($this->_head_favicon))
        {
            $faviconpath = $this->_dir;        
            $html = <<<FAVICON
<link href="{$faviconpath}"rel="icon" type="image/x-icon" />
FAVICON;
        
        }
        return $html;
    }
    
    private function createHTML_CSS() {
        $html = "";
        $pathcss = $this->toURLs($this->_arr_css, $this->_dir_css);
        foreach($pathcss as $cssfile)
        {
            $cssmarkup = <<<SCRIPT
<link href="{$cssfile}" rel="stylesheet">

SCRIPT;
            $html .= $cssmarkup;
        }
        return $html;
    }
    
    //BODY CREATION FUNCTIONS
    private function createHTML_Body() {
        $this->createHTML_JS();
        $html = <<<BODY
<body>
    <!--PHP GENERATED PAGE CONTENT -->
    {$this->_body_content}
    
    <!-- EXTERNAL SCRIPTS -->
    {$this->createHTML_JS()}
</body>
BODY;
        return $html;
    }
    
    private function createHTML_JS() {
        $html = "";
        $pathjs = $this->toURLs($this->_arr_js, $this->_dir_js);
        foreach($pathjs as $jsfile)
        {
        $jsmarkup = <<<SCRIPT
<script src="{$jsfile}"></script>
SCRIPT;
        $html .= $jsmarkup;
        }
        return $html;
    }
    
    //HELPER FUNCTIONS
    
    //Convertings set of soucre files into an 
    //array of URLs given the base path.
    function toURLs(array &$array, $path) {
        $patharray = [];
        foreach($array as $file)
        {
            $patharray[] = "{$path}/{$file}";
        }
        return $patharray;
    }

}
?>