
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>
<?php include 'header.php'; ?>
<body style="background-size: cover;background-color: red;">
<div class="row d-flex align-items-center justify-content-center">

    <div  style="width: 23rem;" class=" bg-white pt-5 mt-4 mb-3 rounded">
        <form action="processor.php" method="post">
            <h2 style="text-align: center; border-bottom: 2px solid grey;">Register Here</h2>
            <?php
            session_start();
            if(isset($_SESSION['register'])){
                ?>
                <div>
                    <p class="text-white bg-danger btn-danger p-2"><?php echo $_SESSION['register']; ?> ?</p>
                </div>
                <?php
                unset($_SESSION['register']);
            }
            ?>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Confirm Password</label>
                <input type="password" name="password2" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>


            <button type="submit" name="register" class="btn btn-primary w-100">Register</button>

        </form>
        <p class="text-center text-uppercase" >Already have an account? <a  href="login.php">Click here</a></p>
    </div>
</div>
</div>
</body>
</html>
