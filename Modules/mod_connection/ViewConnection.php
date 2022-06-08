<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php


class ViewConnection
{

    public function viewLoginPage()
    {
?>
        <div class="loginPage mx-auto">

            <h2 class="mb-4">Login</h2>
            <form action="index.php?module=connection&action=login" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Enter username" name="username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                    <a href=""><small class="form-text text-muted">Forgot password</small></a>
                </div>
                <button type="submit" class="btn btn-danger">Login</button>
            </form>

        </div>

    <?php
    }

    public function viewAlertWarning($msg)
    {
    ?>
        <div class="alert alert-warning text-center loginAlert mx-auto mt-3" role="alert"><?php echo $msg; ?></div>
<?php
    }
}
