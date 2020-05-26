<?php
//INCLUDING API
include("api/api.inc.php");

//PAGE GENERATION LOGIC
function createPage() {
    $content = <<<PAGE
<h1>Error 404</h1>
<h2>Sorry, we couldn't find what you were looking for...</h2>
<p><a href="index.php" class="btn btn-primary">Go Home</a></p>
PAGE;
    return $content;
}

//BUSINESS LOGIC
$pagetitle = "404: Error Page";
$pagecontent = createPage();

//BUILDING HTML PAGE
$page = new MasterPage($pagetitle);
$page->setDynamic2($pagecontent);
$page->renderPage();
?>