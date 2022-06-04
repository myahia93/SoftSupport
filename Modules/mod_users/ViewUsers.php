<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php


class ViewUsers
{
    public function viewUsersPage($tab)
    {
?>
        <h1 class="display-3"><a id="titleLink" href="index.php?module=users&action=form_create_user">Create a user</a></h1>


        <hr class="my-5">
        <h1 class="display-4">User List</h1>
        <?php
        $cmpt = 0;
        ?>
        <div class="row listUser listUserTop">
            <div class="col-md-2">
                <span>Username</span><span class="text-secondary">#ID</span>
            </div>
            <div class="col-md-2">
                <span>Name</span>
            </div>
            <div class="col-md-4">
                <span>Mail</span>
            </div>
            <div class="col-md-2">
                <span>Role</span>
            </div>
            <div class="col-md-2 right">
            </div>
        </div>
        <?php
        foreach ($tab as $key => $value) {
            $cmpt++;
        ?>
            <div class="row listUser <?php if ($cmpt == sizeof($tab)) { ?> listUserBottom<?php }
                                                                                        if ($cmpt % 2 == 0) { ?> listUserGrey<?php } ?>">
                <div class="col-md-2 bold">
                    <span><?php echo strtoupper($value['username']); ?></span><span class="text-secondary"><?php echo "#00" . $value['id_user']; ?></span>
                </div>
                <div class="col-md-2">
                    <span><?php echo $value['first_name'] . " " . strtoupper($value['last_name']); ?></span>
                </div>
                <div class="col-md-4">
                    <span><?php echo $value['mail']; ?></span>
                </div>
                <div class="col-md-2">
                    <span>
                        <?php
                        $role = "";
                        if ($value['isDev'] == 1) {
                            $role = "Developer";
                        } elseif ($value['isReporter'] == 1) {
                            $role = "Reporter";
                        } else {
                            $role = "Administrator";
                        }
                        echo $role
                        ?>
                    </span>
                </div>
                <div class="col-md-2 right">
                    <form method="POST" action="index.php?module=users&action=form_edit_user">
                        <input type="hidden" name="id_user" value="<?php echo $value['id_user']; ?>">
                        <button class="btn btn-dark" type="submit">Edit</button>
                    </form>
                </div>
            </div>
        <?php
        }
        ?>

    <?php
    }

    public function viewFormUserCreation()
    {
    ?>
        <h2 class="display-4 mb-4">Create a user</h2>
        <div class="createUser">
            <form action="index.php?module=users&action=create_user" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Enter a username" name="username" required>
                </div>
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Enter a first name" name="first_name" required>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Enter a last name" name="last_name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" autocomplete="off" placeholder="Enter an email" name="mail" required>
                </div>
                <div class="form-group">
                    <label>User Type</label>
                    <select class="form-control" name="type" required>
                        <option value="1">Developer</option>
                        <option value="2">Reporter</option>
                        <option value="3">Administrator</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Enter password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" placeholder="Enter password" name="password_confirmed" required>
                </div>
                <button type="submit" class="btn btn-dark">Create</button>
            </form>
        </div>
    <?php
    }

    public function viewFormUserEditor($tab)
    {
    ?>

        <h2 class="display-4 mb-4">Edit <?php echo $tab['username'] . "#00" . $tab['id_user']; ?> information</h2>
        <div class="createUser">
            <form action="index.php?module=users&action=edit_user" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" autocomplete="off" value="<?php echo $tab['username']; ?>" disabled>
                </div>
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Enter a first name" value="<?php echo $tab['first_name']; ?>" name="first_name" required>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Enter a last name" value="<?php echo $tab['last_name']; ?>" name="last_name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" autocomplete="off" placeholder="Enter an email" value="<?php echo $tab['mail']; ?>" name="mail" required>
                </div>
                <div class="form-group">
                    <label>User Type</label>
                    <select class="form-control" name="type" required>
                        <option value="1" <?php if ($tab['isDev'] == 1) {  ?> selected <?php } ?>>Developer</option>
                        <option value="2" <?php if ($tab['isReporter'] == 1) {  ?> selected <?php } ?>>Reporter</option>
                        <option value="3" <?php if ($tab['isAdmin'] == 1) {  ?> selected <?php } ?>>Administrator</option>
                    </select>
                </div>
                <input type="hidden" name="id_user" value="<?php echo $tab['id_user']; ?>">
                <input type="hidden" name="username" value="<?php echo $tab['username']; ?>">
                <button type="submit" class="btn btn-dark">Update</button>
                <a href="deleteUserModal" data-toggle="modal" data-target="#deleteUserModal"><button type="button" class="btn btn-danger">Delete</button></a>
            </form>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete the user <span><?php echo $tab['username']; ?></span> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger"><a id="logoutLink" href="index.php?module=users&action=delete_user&id=<?php echo $tab['id_user']; ?>">Delete</a></button>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }

    public function viewAlertWarning($msg)
    {
    ?>
        <div class="alert alert-warning text-center mx-auto mt-3" role="alert"><?php echo $msg; ?></div>
    <?php
    }

    public function viewAlertSuccess($msg)
    {
    ?>
        <div class="alert alert-success text-center mx-auto mt-3" role="alert"><?php echo $msg; ?></div>
<?php
    }
}
