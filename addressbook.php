<?php
    session_start();
    if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
        header('location: login.php');
        exit;
    }
    
    use Anthony\AddressBook;

    $sortBy = isset($_POST['sort']) ? $_POST['sort'] : 'id';
    $orderBy = isset($_POST['order']) ? $_POST['order'] : 'asc';

    require_once __DIR__ . '/models/AddressBook.php';
    $addressbook = new AddressBook();
    $contacts = $addressbook->getAll($sortBy, $orderBy);
?>

<?php require_once __DIR__ . '/pages/header.php'; ?>

<section id="content">
    <div class="container border p-4 mt-4">
        <h1 class="mt-4 font-weight-bolder text-center"><?php echo $_SESSION['user_name']; ?>'s Address Book</h1>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 mt-4 d-flex justify-content-between">
                <div class="form-group row">
                    <form id="sortForm" class="d-flex flex-nowrap" method="post">
                        <select name="sort" id="sort" class="form-control mr-1">
                            <option value="id" <?php if ($sortBy == 'id') { echo 'selected'; } ?>>Sort By</option>
                            <option value="name" <?php if ($sortBy == 'name') { echo 'selected'; } ?>>Name</option>
                            <option value="relationship" <?php if ($sortBy == 'relationship') { echo 'selected'; } ?>>Relationship</option>
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
                    <a class="btn btn-success text-uppercase mr-2" href="./address-form.php?action=new" role="button">New Contact</a>
                    <a class="btn btn-danger text-uppercase" href="./logout.php" role="button">Logout</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped" id="my-addressbook">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Relationship</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col">City</th>
                            <th scope="col">Zip</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($contacts) && count($contacts) > 0) { ?>
                            <?php foreach ($contacts as $idx => $contact) { ?>
                            <tr>
                                <td class="text-center"><?php echo $idx + 1; ?></td>
                                <td><?php echo $contact['name']; ?></td>
                                <td class="text-capitalize"><?php echo $contact['relationship']; ?></td>
                                <td><?php echo $contact['phone']; ?></td>
                                <td><?php echo $contact['address']; ?></td>
                                <td><?php echo $contact['city']; ?></td>
                                <td><?php echo $contact['zip']; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-info text-uppercase" href="./address-form.php?action=update&id=<?php echo $contact['id']; ?>" role="button">Edit</a>
                                    <a class="btn btn-sm btn-danger text-uppercase" href="./address-form.php?action=delete&id=<?php echo $contact['id']; ?>" role="button">Delete</a>
                                </td>
                            </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="8" class="text-center text-danger">No Contacts</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="./vendor/jquery/jquery-3.6.0.min.js"></script>
<script src="./vendor/bootstrap/bootstrap.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('select#sort, select#order').on('change', function() {
            $("form#sortForm").submit();
        });
    });
</script>

<?php require_once __DIR__ . '/pages/footer.php'; ?>
