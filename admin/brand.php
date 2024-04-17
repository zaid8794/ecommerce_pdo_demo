<?php
require_once "includes/header.php";
require_once "../class/Crud.php";
$obj = new Crud();
$q = $obj->custom_get('category');

$no_of_records_per_page = 10;
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$offset = ($pageno - 1)  * $no_of_records_per_page;
?>
<div class="container">
    <section class="category-section px-5">
        <h1 class="text-uppercase border-bottom">Brand</h1>
        <!-- Modal trigger button -->
        <button type="button" class="btn btn-primary shadow-none add_brand">
            Add New Brand
        </button>

        <!-- Modal Body -->
        <div class="modal fade" id="brandModal" tabindex="-1" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="brand_form">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId"></h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="category_name">Category Name</label>
                                <select name="category_name" id="category_name" class="form-control">
                                    <option value="0" selected disabled>Select Category</option>
                                    <?php
                                    foreach ($q as $row) {
                                    ?>
                                        <option value="<?= $row['category_id'] ?>"><?= $row['category_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brand_name">Brand Name</label>
                                <input type="text" name="brand_name" class="form-control shadow-none" id="brand_name" placeholder="Brand Name">
                                <span id="error" class="text-danger">
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="brand_id" id="brand_id">
                            <input type="hidden" name="form_type" id="form_type">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary save" id="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Brand Name</th>
                    <th>Category Name</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $n = 1;
                foreach ($obj->get('brand LEFT JOIN category ON brand.brand_category_id = category.category_id', $offset, $no_of_records_per_page) as $row) {
                ?>
                    <tr id="brand_<?= $row['brand_id']; ?>">
                        <td><?= $row['brand_id']; ?></td>
                        <td><?= $row['brand_name']; ?></td>
                        <td><?= $row['category_name'] ?></td>
                        <td><?= $row['brand_created_at'] ?></td>
                        <td><button type="button" class="btn btn-primary shadow-none edit" id="<?= $row['brand_id']; ?>"><i class="fas fa-edit"></i></button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-danger shadow-none delete" data-id="<?= $row['brand_id']; ?>"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                <?php
                    $n++;
                }
                ?>
            </tbody>
        </table>
        <ul class="pagination">
            <li class="page-item <?= $pageno == 1 ? 'disabled' : '' ?>"><a class="page-link shadow-none" href="?pageno=1">First</a></li>
            <li class="page-item <?= $pageno <= 1 ? 'disabled' : '' ?>"><a class="page-link shadow-none" href="<?= $pageno <= 1 ? '#' : '?pageno=' . ($pageno - 1) ?>">Previous</a></li>
            <?php
            $total_pages = $obj->pagination('brand', $no_of_records_per_page);
            for ($i = 1; $i <= $total_pages; $i++) {
            ?>
                <li class="page-item <?= $pageno == $i ? 'active' : '' ?>"><a class="page-link shadow-none" href="?pageno=<?= $i ?>"><?= $i ?></a></li>
            <?php
            }
            ?>
            <li class="page-item <?= $pageno >= $total_pages ? 'disabled' : '' ?>"><a class="page-link shadow-none" href="<?= $pageno >= $total_pages ? '#' : '?pageno=' . ($pageno + 1) ?>">Next</a></li>
            <li class="page-item <?= $pageno >= $total_pages ? 'disabled' : '' ?>"><a class="page-link shadow-none" href="?pageno=<?= $total_pages ?>">Last</a></li>
        </ul>
    </section>
</div>
<?php
require_once "includes/footer.php";
?>
<script>
    $(document).ready(function() {
        $(document).on('submit', '#brand_form', function(e) {
            e.preventDefault();
            var fd = new FormData(this);
            $.ajax({
                url: 'action/brand_action.php',
                type: 'POST',
                data: fd,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response.success);
                    if (response.status == 0) {
                        $("#error").html(response.msg_error);
                    }
                    if (response.status == 1) {
                        $("#brand_form")[0].reset();
                        $("#brandModal").modal('hide');
                        $("#error").html('');
                        location.reload();
                    }
                },
            });
        });

        $(".edit").click(function() {
            var brand_id = $(this).attr("id");
            $("#brandModal").modal('show');
            $(".modal-title").text('Update Brand');
            $("#submit").removeClass("btn btn-primary save").addClass("btn btn-warning update").text('Update');
            $("#form_type").val("update_brand");
            $.ajax({
                url: "action/brand_action.php",
                method: "POST",
                data: {
                    brand_id: brand_id,
                    form_type: "edit",
                },
                dataType: "json",
                success: function(res) {
                    var brand_name = res[0].brand_name;
                    var category_id = res[0].brand_category_id;
                    $("#brand_id").val(res[0].brand_id);
                    $("#brand_name").val(brand_name);
                    $("#category_name").val(category_id);

                }
            });
        });

        $(".delete").click(function() {
            $("#form_type").val('delete');
            var brand_id = $(this).data("id");
            var confirm = window.confirm("Are you sure you want to delete this brand?");
            if (confirm) {
                $.ajax({
                    url: "action/brand_action.php",
                    method: "POST",
                    data: {
                        brand_id: brand_id,
                        form_type: "delete",
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.status == 200) {
                            $("#" + res.data).remove();
                        }
                    }
                });
            }
        });
    });
</script>