<?php
include("header.php");
checkUser();
adminArea();
include("./user_header.php");
$msg = "";
$category = "";

$label = "Add";
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $label = "Edit";
    $id = get_safe_value($_GET['id']);
    $res = mysqli_query($con, "select * from category where id ='$id'");
    if (mysqli_num_rows($res) == 0) {
        redirect('category.php');
    }
    $row = mysqli_fetch_assoc($res);
    $category = $row['name'];
}

if (isset($_POST['submit'])) {
    $name = get_safe_value($_POST['name']);
    $type = 'add';
    $sub_sql = "";
    if (isset($_GET['id']) && $_GET['id'] > 0) {
        $type = 'edit';
        $sub_sql = "AND `id` != '$id'";
    }
    $res = mysqli_query($con, "select * from category where `name` ='$name' $sub_sql");
    if (mysqli_num_rows($res) > 0) {
        $msg = "Category already exists";
    } else {
        $sql = "insert into category(name) VALUES ('$name')";
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $sql = "UPDATE category set `name`='$name' where id='$id'";
        }
        mysqli_query($con, $sql);
        redirect('category.php');
    }
}
?>
<h2><?php echo $label; ?> Category</h2>
<a href="category.php">Back</a> <br /><br />
<form method="POST">
    <table>
        <tr>
            <td>Category</td>
            <td><input type="text" name="name" id="name" value="<?php echo $category; ?>" required></td>
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