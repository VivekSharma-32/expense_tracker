<?php
include("header.php");
checkUser();
userArea();
include("./user_header.php");
$msg = "";
$category_id = "";
$item = "";
$price = "";
$details = "";
$expense_date = date('Y-m-d');
$label = "Add";
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $label = "Edit";
    $id = get_safe_value($_GET['id']);
    $res = mysqli_query($con, "select * from expense where id ='$id'");
    if (mysqli_num_rows($res) == 0) {
        redirect('expense.php');
    }
    $row = mysqli_fetch_assoc($res);
    $category_id = $row['category_id'];
    $item = $row['item'];
    $price = $row['price'];
    $details = $row['details'];
    $expense_date = $row['expense_date'];
    if ($row['added_by'] != $_SESSION['UID']) {
        redirect('expense.php');
    }
}

if (isset($_POST['submit'])) {
    $category_id = get_safe_value($_POST['category_id']);
    $item = get_safe_value($_POST['item']);
    $price = get_safe_value($_POST['price']);
    $details = get_safe_value($_POST['details']);
    $expense_date = get_safe_value($_POST['expense_date']);
    $added_on = date('Y-m-d h:i:s');

    $type = 'add';
    $sub_sql = "";
    if (isset($_GET['id']) && $_GET['id'] > 0) {
        $type = 'edit';
        $sub_sql = "AND `id` != '$id'";
    }
    $added_by = $_SESSION['UID'];
    $sql = "insert into expense(category_id, item, price, details, expense_date, added_on,added_by) VALUES ('$category_id','$item','$price','$details','$expense_date','$added_on','$added_by')";
    if (isset($_GET['id']) && $_GET['id'] > 0) {
        $sql = "UPDATE expense set `category_id`='$category_id',`item`='$item',`price`='$price',`details`='$details',`expense_date`='$expense_date',`added_on`='$added_on' where id='$id'";
    }
    mysqli_query($con, $sql);
    redirect('expense.php');
}
?>
<h2><?php echo $label; ?> Expense</h2>
<a href="expense.php">Back</a> <br /><br />
<form method="POST">
    <table>
        <tr>
            <td>Category ID</td>
            <td><?php echo getCategory($category_id, ''); ?></td>
        </tr>
        <tr>
            <td>Item</td>
            <td><input type="item" name="item" id="item" value="<?php echo $item; ?>" required></td>
        </tr>
        <tr>
            <td>Price</td>
            <td><input type="text" name="price" id="price" value="<?php echo $price; ?>" required></td>
        </tr>
        <tr>
            <td>Details</td>
            <td><input type="text" name="details" id="details" value="<?php echo $details; ?>" required></td>
        </tr>
        <tr>
            <td>Expense Date</td>
            <td><input type="date" name="expense_date" id="expense_date" value="<?php echo $expense_date; ?>" required></td>
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