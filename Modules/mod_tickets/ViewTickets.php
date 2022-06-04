<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php


class ViewTickets
{

    public function viewTicketsPage($tab)
    {
?>
        <?php if ($_SESSION['isReporter'] == 1) { ?>
            <h1 class="display-3"><a id="titleLink" href="index.php?module=tickets&action=form_create_ticket">Open a Ticket</a></h1>

            <hr class="my-5">

            <!-- REPORTER ISSUES -->
            <h1 class="display-4">My Issues</h1>
            <?php
            $cmpt = 0;
            ?>
            <div class="row listUser listUserTop">
                <div class="col-md-2">
                    <span>Request</span><span class="text-secondary">#ID</span>
                </div>
                <div class="col-md-1">
                    <span>Project</span>
                </div>
                <div class="col-md-2">
                    <span>Details</span>
                </div>
                <div class="col-md-1">
                    <span>Reporter</span>
                </div>
                <div class="col-md-1">
                    <span>Assignee</span>
                </div>
                <div class="col-md-2">
                    <span>Created</span>
                </div>
                <div class="col-md-3">
                    <span>Status</span>
                </div>
            </div>
            <?php
            if (count($tab['my_tickets']) > 0) {
                foreach ($tab['my_tickets'] as $key => $value) {
                    $cmpt++;
                    $color = "";
                    switch ($value['status']) {
                        case 'Work in progress':
                            $color = "blue";
                            break;
                        case 'Waiting for support':
                            $color = "yellow";
                            break;
                        case 'Done':
                            $color = "green";
                            break;
                        case 'Cancelled':
                            $color = "red";
                            break;
                    }
            ?>
                    <div class="row listUser <?php if ($cmpt == sizeof($tab['my_tickets'])) { ?> listUserBottom<?php }
                                                                                                            if ($cmpt % 2 == 0) { ?> listUserGrey<?php } ?>">
                        <div class="col-md-2 bold">
                            <span><?php echo $value['name_ticket']; ?></span><span class="text-secondary"><?php echo "#0" . $value['id_ticket']; ?></span>
                        </div>
                        <div class="col-md-1">
                            <span><?php echo $value['name_project']; ?></span>
                        </div>
                        <div class="col-md-2">
                            <span><?php echo $value['incident_details']; ?></span>
                        </div>
                        <div class="col-md-1">
                            <span><?php echo $value['name_reporter']; ?></span>
                        </div>
                        <div class="col-md-1">
                            <span><?php echo $value['name_dev']; ?></span>
                        </div>
                        <div class="col-md-2">
                            <span><?php echo $value['creation_date']; ?></span>
                        </div>
                        <div class="col-md-3 bold">
                            <img class="img-fluid" src="Resources/<?php echo $color; ?>_circle.png" alt="Logo du site" width="15"> <span><?php echo $value['status']; ?></span>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="row justify-content-md-center listUser listUserBottom">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <span>No tickets pending for the moment</span>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
            <?php
            }
            ?>


            <hr class="my-5">
        <?php } ?>

        <?php if ($_SESSION['isDev'] == 1) { ?>
            <!-- DEV PENDING ISSUES -->
            <h1 class="display-4">My assigned tickets</h1>
            <?php
            $cmpt = 0;
            ?>
            <div class="row listUser listUserTop">
                <div class="col-md-2">
                    <span>Request</span><span class="text-secondary">#ID</span>
                </div>
                <div class="col-md-1">
                    <span>Project</span>
                </div>
                <div class="col-md-2">
                    <span>Details</span>
                </div>
                <div class="col-md-1">
                    <span>Reporter</span>
                </div>
                <div class="col-md-2">
                    <span>Created</span>
                </div>
                <div class="col-md-3">
                    <span>Status</span>
                </div>
                <div class="col-md-1">
                </div>
            </div>
            <?php
            if (count($tab['assigned_tickets']) > 0) {
                foreach ($tab['assigned_tickets'] as $key => $value) {
                    $cmpt++;
                    $color = "";
                    switch ($value['status']) {
                        case 'Work in progress':
                            $color = "blue";
                            break;
                        case 'Waiting for support':
                            $color = "yellow";
                            break;
                        case 'Done':
                            $color = "green";
                            break;
                        case 'Cancelled':
                            $color = "red";
                            break;
                    }
            ?>
                    <div class="row listUser <?php if ($cmpt == sizeof($tab['assigned_tickets'])) { ?> listUserBottom<?php }
                                                                                                                    if ($cmpt % 2 == 0) { ?> listUserGrey<?php } ?>">
                        <div class="col-md-2 bold">
                            <span><?php echo $value['name_ticket']; ?></span><span class="text-secondary"><?php echo "#0" . $value['id_ticket']; ?></span>
                        </div>
                        <div class="col-md-1">
                            <span><?php echo $value['name_project']; ?></span>
                        </div>
                        <div class="col-md-2">
                            <span><?php echo $value['incident_details']; ?></span>
                        </div>
                        <div class="col-md-1">
                            <span><?php echo $value['name_reporter']; ?></span>
                        </div>
                        <div class="col-md-2">
                            <span><?php echo $value['creation_date']; ?></span>
                        </div>
                        <div class="col-md-3 bold">
                            <img class="img-fluid" src="Resources/<?php echo $color; ?>_circle.png" alt="Logo du site" width="15"> <span><?php echo $value['status']; ?></span>
                        </div>
                        <div class="col-md-1 right">
                            <form method="POST" action="index.php?module=tickets&action=form_update_ticket">
                                <input type="hidden" name="id_ticket" value="<?php echo $value['id_ticket']; ?>">
                                <button class="btn btn-dark" type="submit">Update</button>
                            </form>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="row justify-content-md-center listUser listUserBottom">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <span>No tickets pending for the moment</span>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
            <?php
            }
            ?>
            <hr class="my-5">

            <!-- DEV PENDING ISSUES -->
            <h1 class="display-4">Pending issues</h1>
            <?php
            $cmpt = 0;
            ?>
            <div class="row listUser listUserTop">
                <div class="col-md-2">
                    <span>Request</span><span class="text-secondary">#ID</span>
                </div>
                <div class="col-md-1">
                    <span>Project</span>
                </div>
                <div class="col-md-2">
                    <span>Details</span>
                </div>
                <div class="col-md-1">
                    <span>Reporter</span>
                </div>
                <div class="col-md-2">
                    <span>Created</span>
                </div>
                <div class="col-md-3">
                    <span>Status</span>
                </div>
                <div class="col-md-1">
                </div>
            </div>
            <?php
            if (count($tab['my_tickets']) > 0) {
                foreach ($tab['my_tickets'] as $key => $value) {
                    $cmpt++;
                    $color = "";
                    switch ($value['status']) {
                        case 'Work in progress':
                            $color = "blue";
                            break;
                        case 'Waiting for support':
                            $color = "yellow";
                            break;
                        case 'Done':
                            $color = "green";
                            break;
                        case 'Cancelled':
                            $color = "red";
                            break;
                    }
            ?>
                    <div class="row listUser <?php if ($cmpt == sizeof($tab['my_tickets'])) { ?> listUserBottom<?php }
                                                                                                            if ($cmpt % 2 == 0) { ?> listUserGrey<?php } ?>">
                        <div class="col-md-2 bold">
                            <span><?php echo $value['name_ticket']; ?></span><span class="text-secondary"><?php echo "#0" . $value['id_ticket']; ?></span>
                        </div>
                        <div class="col-md-1">
                            <span><?php echo $value['name_project']; ?></span>
                        </div>
                        <div class="col-md-2">
                            <span><?php echo $value['incident_details']; ?></span>
                        </div>
                        <div class="col-md-1">
                            <span><?php echo $value['name_reporter']; ?></span>
                        </div>
                        <div class="col-md-2">
                            <span><?php echo $value['creation_date']; ?></span>
                        </div>
                        <div class="col-md-3 bold">
                            <img class="img-fluid" src="Resources/<?php echo $color; ?>_circle.png" alt="Logo du site" width="15"> <span><?php echo $value['status']; ?></span>
                        </div>
                        <div class="col-md-1 right">
                            <form method="POST" action="index.php?module=tickets&action=assign_ticket">
                                <input type="hidden" name="id_ticket" value="<?php echo $value['id_ticket']; ?>">
                                <input type="hidden" name="id_dev" value="<?php echo $_SESSION['id_user']; ?>">
                                <button class="btn btn-dark" type="submit">Assign</button>
                            </form>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="row justify-content-md-center listUser listUserBottom">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <span>No tickets pending for the moment</span>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
            <?php
            }
            ?>
            <hr class="my-5">
        <?php } ?>

        <!-- Tickets -->
        <h1 class="display-4">List All Tickets</h1>
        <?php
        $cmpt = 0;
        ?>
        <div class="row listUser listUserTop">
            <div class="col-md-2">
                <span>Request</span><span class="text-secondary">#ID</span>
            </div>
            <div class="col-md-1">
                <span>Project</span>
            </div>
            <div class="col-md-2">
                <span>Details</span>
            </div>
            <div class="col-md-1">
                <span>Reporter</span>
            </div>
            <div class="col-md-1">
                <span>Assignee</span>
            </div>
            <div class="col-md-2">
                <span>Created</span>
            </div>
            <div class="col-md-3">
                <span>Status</span>
            </div>
        </div>
        <?php
        if (count($tab['all_tickets']) > 0) {
            foreach ($tab['all_tickets'] as $key => $value) {
                $cmpt++;
                $color = "";
                switch ($value['status']) {
                    case 'Work in progress':
                        $color = "blue";
                        break;
                    case 'Waiting for support':
                        $color = "yellow";
                        break;
                    case 'Done':
                        $color = "green";
                        break;
                    case 'Cancelled':
                        $color = "red";
                        break;
                }
        ?>
                <div class="row listUser <?php if ($cmpt == sizeof($tab['all_tickets'])) { ?> listUserBottom<?php }
                                                                                                        if ($cmpt % 2 == 0) { ?> listUserGrey<?php } ?>">
                    <div class="col-md-2 bold">
                        <span><?php echo $value['name_ticket']; ?></span><span class="text-secondary"><?php echo "#0" . $value['id_ticket']; ?></span>
                    </div>
                    <div class="col-md-1">
                        <span><?php echo $value['name_project']; ?></span>
                    </div>
                    <div class="col-md-2">
                        <span><?php echo $value['incident_details']; ?></span>
                    </div>
                    <div class="col-md-1">
                        <span><?php echo $value['name_reporter']; ?></span>
                    </div>
                    <div class="col-md-1">
                        <span><?php echo $value['name_dev']; ?></span>
                    </div>
                    <div class="col-md-2">
                        <span><?php echo $value['creation_date']; ?></span>
                    </div>
                    <div class="col-md-3 bold">
                        <img class="img-fluid" src="Resources/<?php echo $color; ?>_circle.png" alt="Logo du site" width="15"> <span><?php echo $value['status']; ?></span>
                        <?php if ($_SESSION['isAdmin'] == 1) { ?>
                            <a id="link_right" href="deleteTicketModal<?php echo $value['id_ticket']; ?>" data-toggle="modal" data-target="#deleteTicketModal<?php echo $value['id_ticket']; ?>"><button type="button" class="btn btn-danger">X</button></a>
                        <?php } ?>
                    </div>
                </div>
                <?php if ($_SESSION['isAdmin'] == 1) { ?>
                    <!-- Modal -->
                    <div class="modal fade" id="deleteTicketModal<?php echo $value['id_ticket']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Ticket</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure to delete the ticket #0<span><?php echo $value['id_ticket']; ?></span> ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger"><a id="logoutLink" href="index.php?module=tickets&action=delete_ticket&id=<?php echo $value['id_ticket']; ?>">Delete</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php
            }
        } else {
            ?>
            <div class="row justify-content-md-center listUser listUserBottom">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <span>No tickets for the moment</span>
                </div>
                <div class="col-md-4">
                </div>
            </div>
        <?php
        }
        ?>



    <?php
    }

    public function viewFormTicketCreation($projects)
    {
    ?>
        <h2 class="display-4 mb-4">Open a Ticket</h2>
        <div class="createUser">
            <form action="index.php?module=tickets&action=create_ticket" method="POST">
                <div class="form-group">
                    <label>Ticket name</label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Enter the ticket name" name="name_ticket" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" placeholder="Describe the issue" name="incident_details" required rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Project</label>
                    <select class="form-control" name="id_project" required>
                        <?php foreach ($projects as $key => $value) { ?>
                            <option value="<?php echo $value['id_project']; ?>"><?php echo $value['name_project']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-dark">Create</button>
            </form>
        </div>
    <?php
    }

    public function viewUpdateTicketStatus($tab)
    {
    ?>
        <h2 class="display-4 mb-4">Update status <?php echo $tab['name_ticket'] . "#0" . $tab['id_ticket']; ?></h2>
        <div class="createUser">
            <form action="index.php?module=tickets&action=update_ticket" method="POST">
                <div class="form-group">
                    <label>Ticket name</label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="<?php echo $tab['name_ticket']; ?>" name="name_ticket" disabled>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" placeholder="<?php echo $tab['incident_details']; ?>" name="incident_details" rows="3" disabled></textarea>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" required>
                        <option value="Work in progress" <?php if ($tab['status'] == "Work in progress") { ?>selected<?php } ?>>Work in progress</option>
                        <option value="Done" <?php if ($tab['status'] == "Done") { ?>selected<?php } ?>>Done</option>
                        <option value="Cancelled" <?php if ($tab['status'] == "Cancelled") { ?>selected<?php } ?>>Cancelled</option>
                    </select>
                </div>
                <input type="hidden" name="id_ticket" value="<?php echo $tab['id_ticket']; ?>">
                <button type="submit" class="btn btn-dark">Update</button>
            </form>
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
