<?php
include("header.php");
checkUser();
adminArea();
include("./user_header.php");



if (isset($_GET['type']) && $_GET['type'] == 'delete' && isset($_GET['id']) && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']);
    mysqli_query($con, "DELETE FROM category where id = '$id'");
    echo '<br>Data deleted<br>';
}

$res = mysqli_query($con, "select * from category order by id desc");

?>
<h2>Category</h2>
<a href="manage_category.php">Add Category</a> <br /><br />
<table border="1">
    <tr>
        <td>S.No</td>
        <td>Name</td>
        <td>Category</td>
    </tr>
    <?php
    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
    ?>
            <tr>

                <td><?php echo $row['id'] ?></td>
                <td><?php echo $row['name'] ?></td>
                <td>
                    <a href="manage_category.php?id=<?php echo $row['id'] ?>">Edit</a> &nbsp;
                    <a href="javascript:void(0)" onclick="delete_confirm('<?php echo $row['id'] ?>','category.php')">Delete</a>
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