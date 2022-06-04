<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "ViewHome.php";

class ContHome
{
    private $viewHome;

    public function __construct()
    {
        $this->viewHome = new ViewHome();
    }

    public function homePage()
    {
        $this->viewHome->viewHomePage();
    }
}
