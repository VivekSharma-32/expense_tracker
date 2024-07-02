<?php
include("header.php");
checkUser();
userArea();
$from = "";
$to = "";
$sub_sql = "";
if (isset($_GET['from'])) {
    $from =  get_safe_value($_GET['from']);
}
if (isset($_GET['to'])) {
    $to = get_safe_value($_GET['to']);
}

if ($from != "" && $to != "") {
    $sub_sql .= " and expense.expense_date between '$from' and '$to'";
}

$res = mysqli_query($con, "select expense.price, category.name,expense.item, expense.expense_date from expense,category where expense.category_id = category.id $sub_sql");
?>
<script>
    setTitle("Dashboard Report");
    selectedLink('dashboard_link');
</script>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Dashboard Reports</h2> <br /><br />
                    <form method="get">
                        <div>
                            <h2>

                                <?php if ($from != "" && $from != "") { ?>
                                    From: <?php echo $from; ?>&nbsp;&nbsp;
                                    -
                                    &nbsp;&nbsp;
                                    To: <?php echo $to; ?>
                                <?php  } ?>
                            </h2>
                        </div>
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
                                        <th>Item</th>
                                        <th>Expense Date</th>
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
                                            <td><?php echo $row['item']; ?></td>
                                            <td><?php echo $row['expense_date']; ?></td>
                                            <td><?php echo $row['price']; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>Total</td>
                                        <td><?php echo $final_price; ?></td>
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

<?php
include("footer.php");

?>