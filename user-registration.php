<?php
	use Anthony\User;
    if (! empty($_POST["signup-submit"])) {
		require_once './models/User.php';
		$user = new User();
		$response = $user->registerUser();
	}
?>
<?php require_once __DIR__ . '/pages/header.php'; ?>

<section id="content">
    <div class="container col-lg-4 col-md-6 col-sm-12 border mt-4">
        <h1 class="mt-4 font-weight-bolder">Registration</h1>
        <form id="signup-form" name="signup-form" method="post" autocomplete="off" action="">
			<?php if (!empty($response)) { ?>
			<div class="row pl-3 pr-3">
				<div class="col-12 alert alert-<?php echo $response['status']; ?>" role="alert">
					<?php echo $response['message']; ?>
				</div>
			</div>
			<?php } ?>
            <input type="hidden" name="signup-submit" value="1" />
			<div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Your Name..." required />
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Your Email..." required />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Your Password..." required />
            </div>
			<div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirm Password..." required />
            </div>
			<div class="form-group">
				<input type="button" class="btn btn-primary" name="sign-btn" id="sign-btn" value="Sign up" />
				<a href="/login.php" class="btn btn-info">Login</a>
			</div>
        </form>
    </div>
</section>

<!-- Message box -->
<div class="position-fixed bottom-0 right-0 p-3" style="z-index: 99999; left: 50%; top: 0; transform: translateX(-50%);">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
        <div class="toast-header bg-success text-white">
            <strong class="mr-auto">Message</strong>
            <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body bg-white text-secondary">
            Hello, world! This is a toast message.
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="../vendor/jquery/jquery-3.6.0.min.js"></script>
<script src="../vendor/bootstrap/bootstrap.min.js"></script>

<script type="text/javascript">
    function showMessage(type, message) {
        var rClass = '';
        var aClass = '';
        if (type == 'success') {
            rClass = 'bg-warning bg-danger';
            aClass = 'bg-success';
        } else if (type == 'warning') {
            rClass = 'bg-success bg-danger';
            aClass = 'bg-warning';
        } else if (type == 'danger') {
            rClass = 'bg-success bg-warning';
            aClass = 'bg-danger';
        }

        $('.toast .toast-header').removeClass(rClass);
        $('.toast .toast-header').addClass(aClass);
        $('.toast .toast-body').html(message);
        $('.toast').toast('show');
    }
    $(document).ready(function() {
        $('input[type=button]#sign-btn').click(function() {
            var username = $('#username').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var confirmPassword = $('#confirm-password').val();
            var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

            if (username.trim() == '') {
                showMessage('danger', 'Username is required.');
                $('#username').val('');
                $('#username').focus();
                return false;
            }

            if (email.trim() == '') {
                showMessage('danger', 'Email is required.');
                $('#email').val('');
                $('#email').focus();
                return false;
            } else if (!emailRegex.test(email)) {
                showMessage('danger', 'Invalid Email Address.');
                $('#email').focus();
                return false;
            }

            if (password.trim() == '') {
                showMessage('danger', 'Password is required.');
                $('#password').val('');
                $('#password').focus();
                return false;
            }

            if (confirmPassword.trim() == '') {
                showMessage('danger', 'Confirm Password is required.');
                $('#confirm-password').val('');
                $('#confirm-password').focus();
                return false;
            }

            if (password.trim() != confirmPassword.trim()) {
                showMessage('danger', 'Password is not matched.');
                $('#password').focus();
                return false;
            }

            $('#username').val(username.trim());
            $('#email').val(email.trim());
            $('#password').val(password.trim());

            $('form#signup-form')[0].submit();
        });
    });
</script>

<?php require_once __DIR__ . '/pages/footer.php'; ?>