<?php
include("header.php");
checkUser();
adminArea();



if (isset($_GET['type']) && $_GET['type'] == 'delete' && isset($_GET['id']) && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']);
    mysqli_query($con, "DELETE FROM users where id = '$id'");
    mysqli_query($con, "DELETE FROM expense where added_by = '$id'");

    echo '<br>Data deleted<br>';
}

$res = mysqli_query($con, "select * from users where role='User' order by id desc");

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
                    <h2>Users</h2>
                    <a href="manage_user.php">Add Users</a> <br /><br />
                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Username</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
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
                            </tbody>
                        </table>
                        <?php
                        include("footer.php");

                        ?>