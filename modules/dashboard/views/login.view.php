<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="resources/assets/images/logo.ico" type="image/x-icon"/>

    <title>Login</title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="resources/assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="resources/assets/css/style_login.css" />
    
    <!-- JavaScript -->
    <script type="text/javascript" src="resources/assets/plugins/jQuery_v1.11.2/jquery.min.js"></script>
    <script type="text/javascript" src="resources/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">

            <h2 class="active">Login System</h2>

            <?php
            if(isset($masuk) && $masuk == false) {
                ?>
                <!-- Alert jika gagal login -->
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
                    <span>Username atau password salah!!</span>
                </div>
                <?php
            }
            ?>

            <form action="" method="post">
                <input type="text" id="username" class="fadeIn second" name="username" placeholder="Username" required autofocus>
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password" required>
                <input type="submit" class="fadeIn fourth" value="Log In">
            </form>

        </div>
    </div>
</body>
</html>
