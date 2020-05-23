<?php

//Class designed to create an object of a HTML page
class HTMLPage {
    //Object Fields
    private $dir_css = "";      //Store the directory for CSS
    private $dir_js = "";       //Store the directory for JavaScript
    private $dir_img = "";      //Store the directory for images
    private $dir_fonts = "";    //Store the directory for fonts
    private $dir_data = "";     //Store the directory for data

    private $arr_js = [];       //Store an array of JavaScript
    private $arr_css = [];      //Store an array of CSS files
    private $arr_meta = [];     //Store an associative array of meta data

    private $head_title = "";   //Store the page title
    private $head_html = "";    //Store the header HTML
    private $head_favicon = ""; //Store the Favicon

    private $body_content = ""; //Store the body content

    //Constructor
    function __construct($title) {
        $this->head_title = $title;
    }

    //Setters
    public function setScriptFileArray($file)
    {
        $this->arr_js[] = $file;
    }

    public function setCSSFileArray($file)
    {
        $this->arr_css[] = $file;
    }

    public function setMetaElementArray($metakey, $metavalue)
    {
        $this->arr_meta[$metakey] = $metavalue;
    }

    public function setPageTitle($title)
    {
        $this->head_title = $title;
    }

    public function setCustomHead($headhtml)
    {
        $this->head_html = $headhtml;
    }
    
    public function setDirCSS($csspath)
    {
        $this->dir_css = $csspath;
    }
    
    public function setDirJS($jspath)
    {
        $this->dir_js = $jspath;
    }
    
    public function setDirImages($imgpath)
    {
        $this->dir_img = $imgpath;
    }
    
    public function setDirFonts($fontpath)
    {
        $this->dir_fonts = $fontpath;
    }
    
    public function setDirData($datapath)
    {
        $this->dir_data = $datapath;
    }
    
    public function setBodyContent($content)
    {
        $this->body_content = $content;
    }
    
    public function setFavIcon($piconfile)
    {
        $this->head_favicon = $piconfile;
    }
}