<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php

include_once "ContHome.php";

class ModHome
{
    private $contHome;

    public function __construct()
    {
        $this->contHome = new ContHome();

        $this->contHome->homePage();
    }
}
