<?php
include("header.php");
checkUser();
adminArea();
$msg = "";
$username = "";
$password = "";

$label = "Add";
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $label = "Edit";
    $id = get_safe_value($_GET['id']);
    $res = mysqli_query($con, "select * from users where id ='$id'");
    if (mysqli_num_rows($res) == 0) {
        redirect('users.php');
    }
    $row = mysqli_fetch_assoc($res);
    $username = $row['username'];
    $password = $row['password'];
}

if (isset($_POST['submit'])) {
    $username = get_safe_value($_POST['username']);
    $password = get_safe_value($_POST['password']);
    $type = 'add';
    $sub_sql = "";
    if (isset($_GET['id']) && $_GET['id'] > 0) {
        $type = 'edit';
        $sub_sql = "AND `id` != '$id'";
    }
    $res = mysqli_query($con, "select * from users where `username` ='$username' $sub_sql");
    if (mysqli_num_rows($res) > 0) {
        $msg = "Username already exists";
    } else {
        // encrypt password 
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "insert into users(username,password,role) VALUES ('$username','$password','User')";
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $sql = "UPDATE users set `username`='$username', `password`='$password' where id='$id'";
        }
        mysqli_query($con, $sql);
        redirect('users.php');
    }
}
?>
<script>
    setTitle("Manage User");
    selectedLink('users_link');
</script>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2><?php echo $label; ?> User</h2>
                    <a href="users.php">Back</a> <br /><br />
                    <div class="card">
                        <div class="card-body card-block">
                            <form method="POST" class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label mb-1">Username</label>
                                    <input class="form-control" type="text" name="username" id="username" value="<?php echo $username; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-1">Password</label>
                                    <input class="form-control" type="password" name="password" id="password" value="<?php echo $password; ?>" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control btn btn-primary btn-sm" type="submit" name="submit" value="Submit">
                                </div>

                                <div class="text-danger text-center"><?php echo $msg; ?></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include("footer.php");

?>