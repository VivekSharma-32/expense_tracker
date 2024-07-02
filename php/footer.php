<br><br>
<br><br>
<br><br>

<div id="footer">
    &copy; Copyright
    <?php
    echo date('Y');
    ?>
</div>
<script>
    function change_cat() {
        var category_id = document.getElementById("category_id").value;
        window.location.href = "?category_id=" + category_id;
    }

    function delete_confirm(id, page) {
        var check = confirm("Are you sure?")
        if (check == true) {
            window.location.href = page + '?type=delete&id=' + id;
        }
    }

    function set_to_date() {
        var from_date = document.getElementById("from_date").value;
        document.getElementById("to_date").setAttribute('min', from_date);
    }
</script>
</body>

</html>