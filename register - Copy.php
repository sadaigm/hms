<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/reg_user.css">
</head>

<body>
   <?php include "pagelayout/navbar.php" ?>
    <div id="login_form"></div>
    <div id="div_jum">
        <div class="row register-form">
            <div class="col-md-8 col-md-offset-2">
                <form class="form-horizontal custom-form">
                    <h1>Register Form</h1>
                    <div class="form-group">
                        <div class="col-sm-4 label-column">
                            <label class="control-label" for="name-input-field">Name </label>
                        </div>
                        <div class="col-sm-6 input-column">
                            <input class="form-control" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 label-column">
                            <label class="control-label" for="email-input-field">Email </label>
                        </div>
                        <div class="col-sm-6 input-column">
                            <input class="form-control" type="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 label-column">
                            <label class="control-label" for="pawssword-input-field">Password </label>
                        </div>
                        <div class="col-sm-6 input-column">
                            <input class="form-control" type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 label-column">
                            <label class="control-label" for="repeat-pawssword-input-field">Repeat Password </label>
                        </div>
                        <div class="col-sm-6 input-column">
                            <input class="form-control" type="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 label-column">
                            <label class="control-label" for="dropdown-input-field">Dropdown </label>
                        </div>
                        <div class="col-sm-4 input-column">
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">Dropdown <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">First Item</a></li>
                                    <li><a href="#">Second Item</a></li>
                                    <li><a href="#">Third Item</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox">I've read and accept the terms and conditions</label>
                    </div>
                    <button class="btn btn-default submit-button" type="button">Submit Form</button>
                </form>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>