<?php
include("header.php");
checkUser();
adminArea();
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
<script>
    setTitle("Category");
    selectedLink('category_link');
</script>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2><?php echo $label; ?> Category</h2>
                    <a href="category.php">Back</a> <br /><br />
                    <div class="card">
                        <div class="card-body card-block">
                            <form method="POST" class="form-horizontal">
                                <div class="form-group">
                                    <label class="control-label mb-1">Category</label>
                                    <input class="form-control" type="text" name="name" id="name" value="<?php echo $category; ?>" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control btn btn-primary btn-sm" type="submit" name="submit" value="Submit">
                                </div>
                            </form>
                            <div class="text-danger text-center"><?php echo $msg; ?></div>
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