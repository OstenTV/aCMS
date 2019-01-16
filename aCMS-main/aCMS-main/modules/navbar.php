
<!-- Notice bars -->
<section class="bg-primary">
    <div class="container" style="text-align: center;">
        <div class="row">
            <div class="col">
                <h6 style="margin-bottom: 5px;">Please note that this website is still under consctruction. Submit your feedback <a href="/?view=feedback">here</a>.</h6>
            </div>
        </div>
    </div>
</section>
<?php if (!$allowedCookies): ?>
<section class="bg-primary">
    <form class="container" style="text-align: center;" action="/?script=cookie" method="post">
        <div class="row">
            <div class="col-12 col-md-10">
                By using this site you agree to our use of chocolate cookies. Please read our <a href="/?view=privacy">Privacy Policy</a>. You'll have to accept this again in <?php echo 315569520; ?> seconds.
            </div>
            <div class="col-12 col-md-2">
                <input type="hidden" name="return" value="<?php echo $_GET['view']; ?>" />
                <button type="submit" name="allow" value="true">I agree</button>
            </div>
        </div>
    </form>
</section>
<?php endif; ?>

<!-- Banner -->
<a href="/"><img class="img-fluid d-none d-sm-block banner" src="/content/images/banner.jpg" /></a>

<!-- Navbar -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
    <div class="container">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/">OstenTV</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li id="nav-button-home" class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li id="nav-button-services" class="nav-item">
                    <a class="nav-link" href="/?view=services">Services</a>
                </li>
                <li id="nav-button-downloads" class="nav-item">
                    <a class="nav-link" href="/?view=downloads">Downloads</a>
                </li>
                <li id="nav-button-faq" class="nav-item">
                    <a class="nav-link" href="/?view=faq">FAQ</a>
                </li>
                <li id="nav-button-contact" class="nav-item">
                    <a class="nav-link" href="/?view=contact">Contact</a>
                </li>
                <li id="nav-button-feedback" class="nav-item">
                    <a class="nav-link" href="/?view=feedback">Feedback</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user'])): ?>
                <li id="nav-button-profile" class="nav-item">
                    <a class="nav-link" href="/?view=profile">
                        Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/?script=user&action=LogOut&return=<?php echo $_GET['view']; ?>">
                        Log Out
                    </a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#LogInModal" href="#">
                        Log In
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#RegisterModal" href="#">
                        Sign Up
                    </a>
                </li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</nav>
<script type="text/javascript" src="/scripts/JS/util/navbar.js"></script>

<!-- Modals -->
<div class="modal fade" id="RegisterModal" tabindex="-1" role="dialog" aria-labelledby="RegisterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="RegisterModalLabel">Register</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/?script=user&action=Register&return=<?php echo $_GET['view']; ?>" method="post">
                <div class="modal-body container">
                    <?php if (isset($_GET['register_error'])): ?>
                    <div class="alert alert-dismissible alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Oh snap!</strong> <?php echo $_GET['register_error']; ?>
                    </div>
                    <?php endif; ?>
                    <fieldset>
                        <div class="form-group row">
                            <input class="col" type="email" name="email" value="" placeholder="E-Mail*" required />
                        </div>
                        <div class="form-group row">
                            <input class="col" type="text" name="username" value="" placeholder="Username*" required />
                        </div>
                        <div class="form-group row">
                            <input class="col" type="password" name="password" value="" placeholder="Password*" required />
                        </div>
                        <div class="form-group row">
                            <input class="col" type="password" name="confirm_password" value="" placeholder="Confirm password*" required />
                        </div>
                        <div class="form-group row">
                            <input class="col" type="password" name="activation_code" value="" placeholder="Activation code*" required />
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="LogInModal" tabindex="-1" role="dialog" aria-labelledby="LogInModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="LogInModalLabel">Log In</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/?script=user&action=logIn&return=<?php echo $_GET['view']; ?>" method="post">
                <div class="modal-body container">
                    <?php if (isset($_GET['login_error'])): ?>
                    <div class="alert alert-dismissible alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Oh snap!</strong> <?php echo $_GET['login_error']; ?>
                    </div>
                    <?php endif; ?>
                    <fieldset>
                        <div class="form-group row">
                            <input class="col" type="text" name="username" value="" placeholder="username*" required />
                        </div>
                        <div class="form-group row">
                            <input class="col" type="password" name="password" value="" placeholder="Password*" required />
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#ForgotPasswordModal">Forgot password</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Log In</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ForgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="ForgotPasswordLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ForgotPasswordlLabel">Forot password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/?script=user&action=forgotpassword&return=<?php echo $_GET['view']; ?>" method="post">
                <div class="modal-body container">
                    <div class="alert alert-dismissible alert-danger">
                        <strong>This feature is not added yet.</strong>
                    </div>
                    <fieldset>
                        <div class="form-group row">
                            <input class="col" type="text" name="email" value="" placeholder="E-Mail*" required />
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary disabled">Send E-Mail</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Javascript is off notice -->
<noscript>
    <?php
    echo Alert('warning', 'Why didn\'t you enable Javascript? Turn it on, silly.');
    ?>
</noscript>