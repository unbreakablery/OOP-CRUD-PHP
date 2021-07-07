<?php
    if (isset($_GET['message'])) {
        $message = urldecode($_GET['message']);
    } else {
        $message = '';
    }
?>
<?php require_once __DIR__ . '/pages/header.php'; ?>

<section id="content">
    <div class="container">
        <div class="col-12 mt-4 mb-4">
            <h2 class="font-weight-bolder text-danger">Sorry, Operation Error!</h2>
            <?php if (! empty($message)) { ?>
            <div class="alert alert-danger">
                <?php echo $message; ?>
            </div>
            <?php } ?>
        </div>
        <div class="col-12">
            <a href="./index.php" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/pages/footer.php'; ?>