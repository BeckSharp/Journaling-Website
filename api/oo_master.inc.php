<?php

//Including HTML Page Class
require_once("oo_page.inc.php");

class MasterPage {
    //FIELD MEMBERS
    private $_htmlpage;     //Holds custom instance of the HTML page
    private $_dynamic_1;    //Represents Dynamic Content #1
    private $_dynamic_2;    //Represents Dynamic Content #2
    private $_dynamic_3;    //Represents Dynamic Content #3

    //CONSTRUCTORS
    function __construct($title) {
        $this->_htmlpage = new HTMLPage($title);
        $this->setPageDefaults();
        $this->setDynamicDefaults();
    }

    //GETTERS
    public function getDynamic1() { return $this->_dynamic_1; }
    public function getDynamic2() { return $this->_dynamic_2; }
    public function getDynamic3() { return $this->_dynamic_3; }
    public function getPage(): HTMLPage { return $this->_htmlpage; }

    //SETTERS
    public function setDynamic1($html) { $this->_dynamic_1 = $html; }
    public function setDynamic2($html) { $this->_dynamic_2 = $html; }
    public function setDynamic3($html) { $this->_dynamic_3 = $html; }

    //PUBLIC FUNCTIONS
    public function createPage() {
       $this->setMasterContent();
       return $this->_htmlpage->createPage();
    }

    public function renderPage() {
       $this->setMasterContent();
       $this->_htmlpage->renderPage();
    }

    public function addCSSFile($cssfile) {
        $this->_htmlpage->addCSSFile($cssfile);
    }

    public function addScriptFile($jsfile) {
        $this->_htmlpage->addScriptFile($jsfile);
    }

    //PRIVATE FUNCTIONS
    private function setPageDefaults() {
        $this->_htmlpage->setMediaDirectory("css","js","fonts","img","data");
        $this->addCSSFile("bootstrap.css");
        $this->addCSSFile("site.css");
        $this->addScriptFile("jquery-2.2.4.js");
        $this->addScriptFile("bootstrap.js");
        $this->addScriptFile("holder.js");
    }

    private function setDynamicDefaults() {
        $year = date("Y");
        $this->_dynamic_1 = "";
        $this->_dynamic_2 = "";
        $this->_dynamic_3 = <<<FOOTER
<p>Thomas Beck - Making Life Easier With Journals&copy; {$year}</p>
FOOTER;
    }

    private function setMasterContent() {
        $masterpage = <<<MASTER
<div class="jumbotron">
    {$this->_dynamic_1}
</div>
<div class="row details">
    {$this->_dynamic_2}
</div>
<footer class="footer">
    {$this->_dynamic_3}
</footer>
MASTER;
        $this->_htmlpage->setBodyContent($masterpage);
    }

}
?>