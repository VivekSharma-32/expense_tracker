<?php
include("header.php");
checkUser();

$category_id = "";
$sub_sql = "";
$from = "";
$to = "";
if (isset($_GET['category_id']) && $_GET['category_id'] > 0) {
    $category_id = get_safe_value($_GET['category_id']);
    $sub_sql = " and category.id = $category_id";
}

if (isset($_GET['from'])) {
    $from =  get_safe_value($_GET['from']);
}
if (isset($_GET['to'])) {
    $to = get_safe_value($_GET['to']);
}

if ($from != "" && $to != "") {
    $sub_sql .= " and expense.expense_date between '$from' and '$to'";
}

$res = mysqli_query($con, "select sum(expense.price) as price,category.name from expense,category where expense.category_id = category.id and expense.added_by='" . $_SESSION['UID'] . "' $sub_sql group by expense.category_id");
?>
<script>
    setTitle("Reports");
    selectedLink('reports_link');
</script>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Reports</h2><br /><br />
                    <div class="card">
                        <div class="card-body card-block">
                            <form method="get" class="form-horizontal">
                                <div class="row">
                                    <div class="col-lg-6">
                                        From: <input class="form-control" type="date" name="from" value="<?php echo $from; ?>" max="<?php echo date('Y-m-d') ?>" onchange="set_to_date()" id="from_date">
                                    </div>
                                    <div class="col-lg-6">
                                        To: <input class="form-control" type="date" name="to" value="<?php echo $to; ?>" max="<?php echo date('Y-m-d') ?>" id="to_date">
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <?php echo getCategory($category_id, 'reports'); ?>
                                </div>
                                <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                <a href="reports.php" class="btn btn-secondary">Reset</a>
                            </form>
                            <br>
                            <br>
                            <?php

                            if (mysqli_num_rows($res) > 0) {
                            ?>
                                <div class="table-responsive table--no-card m-b-30">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $final_price = 0;
                                            while ($row = mysqli_fetch_assoc($res)) {
                                                $final_price = $final_price + $row['price'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['name']; ?></td>
                                                    <td><?php echo $row['price']; ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>

                                            <tr>
                                                <th>Total</th>
                                                <th><?php echo $final_price; ?></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php
                            } else {
                                echo "<b>No Data found</b>";
                            }
                                ?>
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