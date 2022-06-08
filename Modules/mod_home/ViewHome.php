<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php


class ViewHome
{

    public function viewHomePage()
    {
?>

        <h1 class="display-1 text-center">Welcome to Softsupport</h1>

        <hr class="my-5">

        <?php if (!isset($_SESSION['id_user'])) { ?>
            <h1 class="display-3"><a id="titleLink" href="index.php?module=connection&action=form_login">Log in</a></h1>

            <hr class="my-5">
        <?php } else { ?>

            <?php if ($_SESSION['isReporter'] == 1) { ?>
                <h1 class="display-3"><a id="titleLink" href="index.php?module=tickets&action=form_create_ticket">Open a Ticket</a></h1>

                <hr class="my-5">

                <h1 class="display-4"><a id="titleLink" href="index.php?module=projects">View Projects</a></h1>

                <hr class="my-5">

                <h1 class="display-4"><a id="titleLink" href="index.php?module=customers">View Customers</a></h1>

                <hr class="my-5">
            <?php } ?>


            <?php if ($_SESSION['isDev'] == 1) { ?>
                <h1 class="display-3"><a id="titleLink" href="index.php?module=tickets">My assigned tickets</a></h1>

                <hr class="my-5">

                <h1 class="display-4"><a id="titleLink" href="index.php?module=projects&action=form_create_project">Create a Project</a></h1>

                <hr class="my-5">

                <h1 class="display-4"><a id="titleLink" href="index.php?module=customers&action=form_create_customer">Add a Customer</a></h1>

                <hr class="my-5">
            <?php } ?>


            <?php if ($_SESSION['isAdmin'] == 1) { ?>
                <h1 class="display-3"><a id="titleLink" href="index.php?module=users&action=form_create_user">Create a user</a></h1>

                <hr class="my-5">

                <h1 class="display-4"><a id="titleLink" href="index.php?module=tickets">View Tickets</a></h1>

                <hr class="my-5">

                <h1 class="display-4"><a id="titleLink" href="index.php?module=projects">View Projects</a></h1>

                <hr class="my-5">

                <h1 class="display-4"><a id="titleLink" href="index.php?module=customers">View Customers</a></h1>

                <hr class="my-5">
            <?php } ?>
        <?php } ?>



<?php
    }
}
