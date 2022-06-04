<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php


class ViewProjects
{

    public function viewProjectsPage($tab)
    {
?>
        <?php if ($_SESSION['isReporter'] != 1) { ?>
            <h1 class="display-3"><a id="titleLink" href="index.php?module=projects&action=form_create_project">Create a project</a></h1>

            <hr class="my-5">
        <?php } ?>

        <h1 class="display-4">Project List</h1>

        <?php
        $cmpt = 0;
        ?>
        <div class="row listUser listUserTop">
            <div class="col-md-2">
                <span>Project</span><span class="text-secondary">#ID</span>
            </div>
            <div class="col-md-2">
                <span>Customer</span>
            </div>
            <div class="col-md-4">
                <span>Description</span>
            </div>
            <div class="col-md-2">
                <span>Status</span>
            </div>
            <div class="col-md-2 right">
            </div>
        </div>
        <?php
        foreach ($tab as $key => $value) {
            $cmpt++;
            $color = "";
            switch ($value['status_project']) {
                case 'In development':
                    $color = "blue";
                    break;
                case 'Under test':
                    $color = "yellow";
                    break;
                case 'In production':
                    $color = "green";
                    break;
                case 'Blocked':
                    $color = "red";
                    break;
            }
        ?>
            <div class="row listUser <?php if ($cmpt == sizeof($tab)) { ?> listUserBottom<?php }
                                                                                        if ($cmpt % 2 == 0) { ?> listUserGrey<?php } ?>">
                <div class="col-md-2 bold">
                    <span><?php echo $value['name_project']; ?></span><span class="text-secondary"><?php echo "#00" . $value['id_project']; ?></span>
                </div>
                <div class="col-md-2">
                    <span><?php echo $value['name_customer']; ?></span>
                </div>
                <div class="col-md-4">
                    <span><?php echo $value['description']; ?></span>
                </div>
                <div class="col-md-2 bold">
                    <img class="img-fluid" src="Resources/<?php echo $color; ?>_circle.png" alt="Logo du site" width="15"> <span><?php echo $value['status_project']; ?></span>
                </div>
                <div class="col-md-2 right">
                    <!-- TODO edit project -->
                    <form method="POST" action="index.php?module=projects&action=form_edit_project">
                        <input type="hidden" name="id_project" value="<?php echo $value['id_project']; ?>">
                        <button class="btn btn-dark" type="submit">Edit</button>
                    </form>
                </div>
            </div>
        <?php
        }
        ?>

    <?php
    }

    public function viewFormProjectCreation($customers)
    {
    ?>
        <h2 class="display-4 mb-4">Create a Project</h2>
        <div class="createUser">
            <form action="index.php?module=projects&action=create_project" method="POST">
                <div class="form-group">
                    <label>Project name</label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Enter the project name" name="name_project" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" placeholder="Describe the project" name="description" required rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Customer</label>
                    <select class="form-control" name="id_customer" required>
                        <?php foreach ($customers as $key => $value) { ?>
                            <option value="<?php echo $value['id_customer']; ?>"><?php echo $value['name_customer']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-dark">Create</button>
            </form>
        </div>
    <?php
    }

    public function viewFormEditProject($tab)
    {
    ?>
        <h2 class="display-4 mb-4">Edit <?php echo $tab['name_project'] . "#00" . $tab['id_project']; ?> information</h2>
        <div class="createUser">
            <form action="index.php?module=projects&action=edit_project" method="POST">
                <div class="form-group">
                    <label>Project name</label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Enter the project name" name="name_project" value="<?php echo $tab['name_project']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" placeholder="Describe the project" name="description" required rows="3"><?php echo $tab['description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Customer</label>
                    <select class="form-control" name="id_customer" required>
                        <?php foreach ($tab['list_customer'] as $key => $value) { ?>
                            <option value="<?php echo $value['id_customer']; ?>" <?php if ($value['id_customer'] == $tab['id_customer']) { ?>selected<?php } ?>><?php echo $value['name_customer']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status_project" required>
                        <option value="In development" <?php if ($tab['status_project'] == "In development") { ?>selected<?php } ?>>In development</option>
                        <option value="Under test" <?php if ($tab['status_project'] == "Under test") { ?>selected<?php } ?>>Under test</option>
                        <option value="In production" <?php if ($tab['status_project'] == "In production") { ?>selected<?php } ?>>In production</option>
                        <option value="Blocked" <?php if ($tab['status_project'] == "Blocked") { ?>selected<?php } ?>>Blocked</option>
                    </select>
                </div>

                <input type="hidden" name="id_project" value="<?php echo $tab['id_project']; ?>">
                <button type="submit" class="btn btn-dark">Update</button>
                <a href="deleteProjectModal" data-toggle="modal" data-target="#deleteProjectModal"><button type="button" class="btn btn-danger">Delete</button></a>
            </form>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="deleteProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete the Project <span><?php echo $tab['name_project']; ?></span> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger"><a id="logoutLink" href="index.php?module=projects&action=delete_project&id=<?php echo $tab['id_project']; ?>">Delete</a></button>
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
