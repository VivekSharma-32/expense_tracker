<?php
include("header.php");
checkUser();
userArea();
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
<script>
    setTitle("Expense");
    selectedLink('expense_link');
</script>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2><?php echo $label; ?> Expense</h2>
                    <a href="expense.php">Back</a> <br /><br />
                    <div class="table-responsive table--no-card m-b-30">
                        <div class="card">
                            <div class="card-body card-block">
                                <form method="POST" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Category</label>
                                        <?php echo getCategory($category_id, ''); ?>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Item</label>
                                        <input type="item" class="form-control" name="item" id="item" value="<?php echo $item; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">Price</label>
                                        <input class="form-control" type="text" name="price" id="price" value="<?php echo $price; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Details</label>
                                        <input class="form-control" type="text" name="details" id="details" value="<?php echo $details; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Expense Date</label>
                                        <input class="form-control" type="date" name="expense_date" id="expense_date" value="<?php echo $expense_date; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <input class="form-control btn btn-primary btn-sm" type="submit" name="submit" value="Submit">
                                    </div>
                                    <?php echo $msg; ?>
                                </form>

                            </div>
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