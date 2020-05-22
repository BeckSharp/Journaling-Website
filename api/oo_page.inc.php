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

}