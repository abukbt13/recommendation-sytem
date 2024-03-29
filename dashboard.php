<?php
session_start();
if (!isset($_SESSION['user_id'])){
    session_start();
    $_SESSION['status'] = 'lOGIN TO VIEW THIS PAGE';
    header('Location:signin.php');
}

$user_id=$_SESSION["user_id"];
$role=$_SESSION["role"];
//echo $user_id;
include "connection.php";
$user="select * from users where id='$user_id'";
$user_run=mysqli_query($conn,$user);
$num=mysqli_num_rows($user_run);
//echo $num;

$users=mysqli_fetch_all($user_run,MYSQLI_ASSOC);
foreach ($users as $user){
    $username=$user["username"];
    $phone=$user["phone"];
    $profile_image=$user["profile_image"];
}


if(isset($_POST['update_profile'])) {
    $newusername = $_POST['username'];
    $newphone = $_POST['phone'];

    $initialpicture = $_POST['image'];


    $profile = $_FILES['profile']['name'];
    $profiletmp = $_FILES['profile']['tmp_name'];
    $profile_new_name = rand() . $profile;

    $path="profiles/";
    $fullpath=$path.$initialpicture;


    if(empty($profile)){

        $update = "update users set  username='$newusername',phone='$newphone' where id='$user_id'";
        $update_run = mysqli_query($conn, $update);
        if ($update_run) {
            session_start();
            $_SESSION['status'] = 'Profile details updated successfully';
            header('Location:dashboard.php');
            die();
        }
    }
    else{


        $update = "update users set profile_image='$profile_new_name', username='$newusername',phone='$newphone' where id='$user_id'";
        $update_run = mysqli_query($conn, $update);
        if ($update_run){
            session_start();
            move_uploaded_file($profiletmp,"profiles/".  $profile_new_name);
            unlink($fullpath);

            $_SESSION['status'] = "Profile Updated";
            header("Location:dashboard.php");
        }

    }

}
include 'header.php';
?>


<div class="body">
    <?php

    if(isset($_SESSION['login'])){
        ?>
        <div>
            <p class="text-white bg-danger btn-danger p-2"><?php echo $_SESSION['login']; ?> ?</p>
        </div>
        <?php
        unset($_SESSION['login']);
    }
    ?>
    <style>
        .body{
            height: 90vh;
            background-color:#DED8D7;
            padding:0rem 0rem 0rem 2rem;
        }
        .main_content{
            background-color: #FFFF;
            height:89vh;

        }
        .sidebar{
            width:16rem;
            height: 85vh;
            background-color: #fff3cd;
        }
        .contents li{
            padding:0.2rem 0.2rem 0.2rem 0.2rem;
            margin:0rem 2rem 0rem 0rem;
            font-size: 16px;
            text-transform: uppercase;
        }
        .contents li:hover{
            background-color: #DED8D7;
            border-radius: 8px;
        }
        .content{
            width: 100%;
        }
        .profile_content{
            /*display: none;*/
            width: 22rem;
            border:solid 1px #faa;
        }
        .bids{
            display:none;
        }
        .successbids{
            display:none;
        }
        .block{display: block;}
    </style>
    <div class="main_content d-flex">
        <i style="font-size: 29px;" id="bar" class="d-block d-md-none d-lg-none fa fa-bars fa-lg" aria-hidden="true"></i>
        <div id="sidebar" class="sidebar d-none d-md-block d-lg-block" >
            <p style="text-align: center; margin-left: 1rem;padding-top:0.5rem;text-transform: uppercase;">Dashboard</p>
            <hr>
            <div class="profile d-flex align-items-center">
                <img style='border-radius: 50%;' src='profiles/<?php echo$profile_image ?>' alt='Uploadprofile' width='100' height='100'>
                <p style="text-align: center; margin-left: 1rem;margin-top: 1rem;text-transform: uppercase;"><?php echo $username; ?></p>
            </div>
            <hr>
            <div class="contents ms-3">
                <li id="profile" class="list-unstyled my-2" id="profile"><a class="text-decoration-none">View My profile</a></li>

                <li id="bids" class="list-unstyled my-2" id="profile"><a class="text-decoration-none">Active Bids</a></li>
                <li id="successbids" class="list-unstyled my-2" id="profile"><a class="text-decoration-none" >Successfull Bids</a></li>

            </div>
        </div>
        <div class="content">
            <div id="profile_content" class="profile_content">
                <form  action="dashboard.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="text" name="image" hidden="" value="<?php echo $profile_image; ?>">
                    </div>
                    <div class="form-group">
                        <h2 style="text-align: center;">Edit profile Info</h2>
                        <div class="" style="display: flex;align-items: center;justify-content: center;">
                            <img style="border-radius: 50%;" src="profiles/<?php echo $profile_image; ?>" alt="profiles pic" width="100" height="100">
                        </div>
                        <div class="form-group d-flex align-items-center flex-column m-2">
                            <p>Change profile pic</p>
                            <input class="inputs" class="form-control" type="file" name="profile">
                        </div>

                        <div class="form-group d-flex align-items-center flex-column m-2">
                            <p>User Name</p>
                            <input class="inputs"  type="text" name="username" value="<?php echo $username; ?>">

                        </div>



                        <div class="form-group d-flex align-items-center flex-column m-2">
                            <p style="text-align: center; font-size: 17px;text-transform: uppercase;">Phone Number</p>
                            <input  class="inputs"  type="number" required name="phone" value="<?php echo $phone; ?>"><br>
                        </div>
                        <div class="form-group d-flex align-items-center flex-column m-2">
                            <button type="submit"  class="btn btn-success"  name="update_profile" >Update profile</button>
                        </div>

                    </div>
                </form>
            </div>


        </div>
    </div>


</div>
<script>
    const profile=document.getElementById("profile");
    const profile_content=document.getElementById("profile_content");
    profile.addEventListener('click', ()=>{
        profile_content.style.display="block";
        bids_content.style.display="block";
        success_bids.style.display="none";
        bids_content.style.display="none";
    })
    const bids=document.getElementById("bids")
    const bids_content=document.getElementById("bids_content")
    bids.addEventListener('click', ()=>{
        bids_content.style.display="block";
        success_bids.style.display="none";
        profile_content.style.display="none";
    })
    const successbids=document.getElementById("successbids")
    const success_bids=document.getElementById("success_bids")
    successbids.addEventListener('click', ()=>{
        success_bids.style.display="block";
        bids_content.style.display="none";
        profile_content.style.display="none";
    })
    const bar=document.getElementById("bar")
    const sidebar=document.getElementById("sidebar")
    bar.addEventListener('click', ()=>{
        sidebar.classList.toggle("d-none");
    })
</script>
</div>