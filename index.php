<?php include "inc/header.php"; ?>

<?php
    spl_autoload_register(function($className) {
        include 'classes/' . $className . '.php';
    });
    
    $sortBy = isset($_POST['sort']) ? $_POST['sort'] : 'id';
    $orderBy = isset($_POST['order']) ? $_POST['order'] : 'asc';
    
    $addressbook = new AddressBook();
    $contacts = $addressbook->getAll($sortBy, $orderBy);
?>

<section id="content">
    <div class="container">
        <h1 class="mt-4 font-weight-bolder">My Address Book</h1>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mt-4 d-flex justify-content-between">
                <div class="form-group row">
                    <form id="sortForm" class="d-flex flex-nowrap" method="post">
                        <select name="sort" id="sort" class="form-control mr-1">
                            <option value="id" <?php if ($sortBy == 'id') { echo 'selected'; } ?>>Sort By</option>
                            <option value="name" <?php if ($sortBy == 'name') { echo 'selected'; } ?>>Name</option>
                            <option value="phone" <?php if ($sortBy == 'phone') { echo 'selected'; } ?>>Phone</option>
                            <option value="address" <?php if ($sortBy == 'address') { echo 'selected'; } ?>>Address</option>
                            <option value="city" <?php if ($sortBy == 'city') { echo 'selected'; } ?>>City</option>
                        </select>
                        <select name="order" id="order" class="form-control">
                            <option value="asc" <?php if ($orderBy == 'asc') { echo 'selected'; } ?>>Ascending</option>
                            <option value="desc" <?php if ($orderBy == 'desc') { echo 'selected'; } ?>>Descending</option>
                        </select>
                    </form>
                </div>
                <div class="form-group row">
                    <a class="btn btn-primary" href="./edit.php?action=new" role="button">Create Address</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col">City</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($contacts) && count($contacts) > 0) { ?>
                            <?php foreach ($contacts as $idx => $contact) { ?>
                            <tr>
                                <td class="text-center"><?php echo $idx + 1; ?></td>
                                <td><?php echo $contact['name']; ?></td>
                                <td><?php echo $contact['phone']; ?></td>
                                <td><?php echo $contact['address']; ?></td>
                                <td><?php echo $contact['city']; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-success" href="./edit.php?action=update&id=<?php echo $contact['id']; ?>" role="button">Update</a>
                                    <a class="btn btn-sm btn-danger" href="./edit.php?action=delete&id=<?php echo $contact['id']; ?>" role="button">Delete</a>
                                </td>
                            </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6" class="text-center text-danger">No Contacts</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="./asset/js/jquery-3.6.0.min.js"></script>
<script src="./asset/js/bootstrap.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('select#sort, select#order').on('change', function() {
            $("form#sortForm").submit();
        });
    });
</script>

<?php include "inc/footer.php"; ?>
