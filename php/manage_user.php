<?php
include("header.php");
checkUser();
adminArea();
include("./user_header.php");
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
<h2><?php echo $label; ?> Manage Users</h2>
<a href="users.php">Back</a> <br /><br />
<form method="POST">
    <table>
        <tr>
            <td>Username</td>
            <td><input type="text" name="username" id="username" value="<?php echo $username; ?>" required></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="password" id="password" value="<?php echo $password; ?>" required></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="Submit"></td>
        </tr>
    </table>
</form>
<?php echo $msg; ?>
<?php
include("footer.php");

?>