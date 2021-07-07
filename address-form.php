<?php
    session_start();
    if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
        header('location: login.php');
        exit;
    }
    
    use Anthony\AddressBook;
    require_once __DIR__ . '/models/AddressBook.php';
    $addressbook = new AddressBook();
    $action = $_GET['action'];
    
    if ($action == 'update') {
        if (!empty($_POST)) {
            $addressbook->setName($_POST['contactName']);
            $addressbook->setRelationship($_POST['relationship']);
            $addressbook->setPhone($_POST['phoneNumber']);
            $addressbook->setAddress($_POST['address']);
            $addressbook->setCity($_POST['city']);
            $addressbook->setZip($_POST['zip']);

            if (empty($_POST['id'])) {
                header("Location: error.php");
                exit;
            }

            $addressbook->update($_POST['id']);

            header("Location: addressbook.php");
            exit;
        } else {
            $contact = $addressbook->getAddressById($_GET['id']);
            if (empty($contact)) {
                header("Location: error.php?message=" . urlencode('Not Found the contact by ID = ' . $_GET['id']));
                exit;
            }
            $pageName = 'Edit Contact';
        }
    } elseif ($action == 'new') {
        if (!empty($_POST)) {
            $addressbook->setName($_POST['contactName']);
            $addressbook->setRelationship($_POST['relationship']);
            $addressbook->setPhone($_POST['phoneNumber']);
            $addressbook->setAddress($_POST['address']);
            $addressbook->setCity($_POST['city']);
            $addressbook->setZip($_POST['zip']);

            $addressbook->create();

            header("Location: addressbook.php");
            exit;
        } else {
            $contact = $addressbook->getBlankAddress();
            $pageName = 'New Contact';
        }
    } elseif ($action == 'delete') {
        if (empty($_GET['id'])) {
            header("Location: error.php?message=" . urlencode('Not Parameter: ID'));
            exit;
        }

        $addressbook->delete($_GET['id']);

        header("Location: addressbook.php");
        exit;
    } else {
        header("Location: error.php");
        exit;
    }
?>

<?php require_once __DIR__ . '/pages/header.php'; ?>

<section id="content">
    <div class="container col-lg-4 col-md-6 col-sm-12 border mt-4">
        <h1 class="mt-4 font-weight-bolder text-center"><?php echo $pageName; ?></h1>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : 0; ?>" />
            <div class="form-group">
                <label for="contactName">Name</label>
                <input type="text" class="form-control" id="contactName" name="contactName" placeholder="Name..." value="<?php echo $contact['name']; ?>" required />
            </div>
            <div class="form-group">
                <label for="relationship">Relationship</label>
                <select name="relationship" id="relationship" class="form-control">
                    <option value="family" <?php if ($contact['relationship'] == 'family') { echo 'selected'; } ?>>Family</option>
                    <option value="friend" <?php if ($contact['relationship'] == 'friend') { echo 'selected'; } ?>>Friend</option>
                    <option value="colleague" <?php if ($contact['relationship'] == 'colleague') { echo 'selected'; } ?>>Colleague</option>
                    <option value="workshop" <?php if ($contact['relationship'] == 'workshop') { echo 'selected'; } ?>>Workshop</option>
                    <option value="customer" <?php if ($contact['relationship'] == 'customer') { echo 'selected'; } ?>>Customer</option>
                    <option value="client" <?php if ($contact['relationship'] == 'client') { echo 'selected'; } ?>>Client</option>
                    <option value="other" <?php if ($contact['relationship'] == 'other') { echo 'selected'; } ?>>Other</option>
                    
                </select>
            </div>
            <div class="form-group">
                <label for="phoneNumber">Phone Number</label>
                <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Phone Number..." value="<?php echo $contact['phone']; ?>" required />
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Address..." value="<?php echo $contact['address']; ?>" />
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="City..." value="<?php echo $contact['city']; ?>" />
            </div>
            <div class="form-group">
                <label for="zip">Zip Code</label>
                <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip Code..." value="<?php echo $contact['zip']; ?>" />
            </div>
            <div class="form-group mb-4">
                <button type="submit" class="btn btn-success">Save Contact</button>
                <a href="./addressbook.php" class="btn btn-secondary">Back To Contacts</a>
            </div>
        </form>
    </div>
</section>

<?php require_once __DIR__ . '/pages/footer.php'; ?>