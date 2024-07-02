<?php
include("header.php");
checkUser();
adminArea();
include("./user_header.php");



if (isset($_GET['type']) && $_GET['type'] == 'delete' && isset($_GET['id']) && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']);
    mysqli_query($con, "DELETE FROM users where id = '$id'");
    mysqli_query($con, "DELETE FROM expense where added_by = '$id'");

    echo '<br>Data deleted<br>';
}

$res = mysqli_query($con, "select * from users where role='User' order by id desc");

?>
<h2>Users</h2>
<a href="manage_user.php">Add Users</a> <br /><br />
<table border="1">
    <tr>
        <td>S.No</td>
        <td>Username</td>
    </tr>
    <?php
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
    ?>
            <tr>

                <td><?php echo $row['id'] ?></td>
                <td><?php echo $row['username'] ?></td>
                <td>
                    <a href="manage_user.php?id=<?php echo $row['id'] ?>">Edit</a> &nbsp;
                    <a href="javascript:void(0)" onclick="delete_confirm('<?php echo $row['id'] ?>','users.php')">Delete</a>
                </td>
            </tr>
        <?php
        }
    } else {
        ?>
        <tr>
            <td>No Data found</td>
        </tr>
    <?php
    }
    ?>
</table>
<?php
include("footer.php");

?>