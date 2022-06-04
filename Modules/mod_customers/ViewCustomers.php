<?php
if (!defined('CONST_INCLUDE'))
    die('Acces denied !');
?>
<?php


class ViewCustomers
{
    public function viewCustomersPage($tab)
    {
?>
        <?php if ($_SESSION['isReporter'] != 1) { ?>
            <h1 class="display-3"><a id="titleLink" href="index.php?module=customers&action=form_create_customer">Add a customer</a></h1>

            <hr class="my-5">
        <?php } ?>

        <h1 class="display-4">Customer List</h1>

        <?php
        $cmpt = 0;
        ?>
        <div class="row listUser listUserTop">
            <div class="col-md-4">
                <span>Customer</span><span class="text-secondary">#ID</span>
            </div>
            <div class="col-md-3">
                <span>Location</span>
            </div>
            <div class="col-md-3">
                <span>Number of Projects</span>
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
                <div class="col-md-4 bold">
                    <span><?php echo $value['name_customer']; ?></span><span class="text-secondary"><?php echo "#00" . $value['id_customer']; ?></span>
                </div>
                <div class="col-md-3">
                    <span><?php echo strtoupper($value['city']); ?></span>
                </div>
                <div class="col-md-3">
                    <span><?php echo $value['projects']; ?></span>
                </div>
                <div class="col-md-2 right">
                    <form method="POST" action="index.php?module=customers&action=form_edit_customer">
                        <input type="hidden" name="id_customer" value="<?php echo $value['id_customer']; ?>">
                        <button class="btn btn-dark" type="submit">Edit</button>
                    </form>
                </div>
            </div>
        <?php
        }
        ?>


    <?php
    }

    public function viewFormCustomerCreation()
    {
    ?>
        <h2 class="display-4 mb-4">Add a customer</h2>
        <div class="createUser">
            <form action="index.php?module=customers&action=create_customer" method="POST">
                <div class="form-group">
                    <label>Company name</label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Enter the company name" name="name_customer" required>
                </div>
                <div class="form-group">
                    <label>Location (city)</label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Enter a city" name="city" required>
                </div>
                <button type="submit" class="btn btn-dark">Create</button>
            </form>
        </div>
    <?php
    }

    public function viewFormEditCustomer($tab)
    {
    ?>
        <h2 class="display-4 mb-4">Edit <?php echo $tab['name_customer'] . "#00" . $tab['id_customer']; ?> information</h2>
        <div class="createUser">
            <form action="index.php?module=customers&action=edit_customer" method="POST">
                <div class="form-group">
                    <label>Company name</label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Enter the company name" value="<?php echo $tab['name_customer']; ?>" name="name_customer" required>
                </div>
                <div class="form-group">
                    <label>Location (city)</label>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Enter a city" value="<?php echo $tab['city']; ?>" name="city" required>
                </div>
                <input type="hidden" name="id_customer" value="<?php echo $tab['id_customer']; ?>">
                <button type="submit" class="btn btn-dark">Update</button>
                <a href="deleteCustomerModal" data-toggle="modal" data-target="#deleteCustomerModal"><button type="button" class="btn btn-danger">Delete</button></a>
            </form>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete the customer <span><?php echo $tab['name_customer']; ?></span> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger"><a id="logoutLink" href="index.php?module=customers&action=delete_customer&id=<?php echo $tab['id_customer']; ?>">Delete</a></button>
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
