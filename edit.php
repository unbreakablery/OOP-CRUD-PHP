<?php include "inc/header.php"; ?>

<?php
    spl_autoload_register(function($className) {
        include 'classes/' . $className . '.php';
    });
    
    $addressbook = new AddressBook();
    $action = $_GET['action'];
    
    if ($action == 'update') {
        if (!empty($_POST)) {
            $addressbook->setName($_POST['contactName']);
            $addressbook->setPhone($_POST['phoneNumber']);
            $addressbook->setAddress($_POST['address']);
            $addressbook->setCity($_POST['city']);

            if (empty($_POST['id'])) {
                header("Location: error.php");
                exit;
            }

            $addressbook->update($_POST['id']);

            header("Location: index.php");
            exit;
        } else {
            $contact = $addressbook->getAddressById($_GET['id']);
            $pageName = 'Update Address';
        }
    } elseif ($action == 'new') {
        if (!empty($_POST)) {
            $addressbook->setName($_POST['contactName']);
            $addressbook->setPhone($_POST['phoneNumber']);
            $addressbook->setAddress($_POST['address']);
            $addressbook->setCity($_POST['city']);

            $addressbook->create();

            header("Location: index.php");
            exit;
        } else {
            $contact = $addressbook->getBlankAddress();
            $pageName = 'New Address';
        }
    } elseif ($action == 'delete') {
        if (empty($_GET['id'])) {
            header("Location: error.php");
            exit;
        }

        $addressbook->delete($_GET['id']);

        header("Location: index.php");
        exit;
    } else {
        header("Location: error.php");
        exit;
    }
?>

<section id="content">
    <div class="container">
        <h1 class="mt-4 font-weight-bolder"><?php echo $pageName; ?></h1>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : 0; ?>" />
            <div class="form-group">
                <label for="contactName">Contact Name</label>
                <input type="text" class="form-control" id="contactName" name="contactName" placeholder="Name..." value="<?php echo $contact['name']; ?>" required />
            </div>
            <div class="form-group">
                <label for="phoneNumber">Phone Number</label>
                <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Phone Number..." value="<?php echo $contact['phone']; ?>" />
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Address..." value="<?php echo $contact['address']; ?>" />
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="City..." value="<?php echo $contact['city']; ?>" />
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="./index.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</section>

<?php include "inc/footer.php"; ?>