<?php
require_once "includes/header.php";
require_once "../class/Crud.php";
$obj = new Crud();
$q = $obj->custom_get('category'); // get category for select
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
        <h1 class="text-uppercase border-bottom">All Products</h1>
        <!-- Modal trigger button -->
        <button type="button" class="btn btn-primary shadow-none add_product">
            Add New Product +
        </button>

        <!-- Modal Body -->
        <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" id="product_form">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId"></h5>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="product_title">Product Title</label>
                                        <input type="text" name="product_title" class="form-control shadow-none" id="product_title" placeholder="Product Title">
                                        <span id="error" class="text-danger">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_name">Category Name</label>
                                        <select name="category_name" id="category_name" class="form-control shadow-none">
                                            <option value="0" selected>Select Category</option>
                                            <?php
                                            foreach ($q as $row) {
                                            ?>
                                                <option value="<?= $row['category_id'] ?>"><?= $row['category_name'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="brand_name">Brand Name</label>
                                        <select name="brand_name" id="brand_name" class="form-control shadow-none">
                                            <option value="0" selected disabled>Select Category First</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="regular_price">Regular Price</label>
                                        <input type="text" name="regular_price" class="form-control shadow-none" id="regular_price" placeholder="Product Regular Price">
                                        <span id="error" class="text-danger">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="selling_price">Selling Price</label>
                                        <input type="text" name="selling_price" class="form-control shadow-none" id="selling_price" placeholder="Product Selling Price">
                                        <span id="error" class="text-danger">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="product_thumbnail">Product Thumbnail</label>
                                        <input type="file" name="product_thumbnail" class="form-control shadow-none" id="product_thumbnail">
                                        <span id="error" class="text-danger">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="short_description">Short Description</label>
                                        <textarea name="short_description" class="form-control shadow-none" id="short_description" placeholder="Product Short Description" rows="5"></textarea>
                                        <span id="error" class="text-danger">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="long_description">Long Description</label>
                                        <textarea name="long_description" class="form-control shadow-none" id="long_description" placeholder="Product Long Description" rows="5"></textarea>
                                        <span id="error" class="text-danger">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Add More Thumbnails</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="file" name="" class="form-control" id="">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success btn-block shadow-none add-more-thumbnail">Add</button>
                                </div>
                            </div>
                            <span class="extra-thumbnail-area"></span>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="product_id" id="product_id">
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
                    <th>Product Thumbnail</th>
                    <th>Product Title</th>
                    <th>Regular Price</th>
                    <th>Selling Price</th>
                    <th>Short Description</th>
                    <th>Long Description</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $n = 1;
                foreach ($obj->get('products LEFT JOIN category ON products.category_id = category.category_id LEFT JOIN brand ON products.brand_id = brand.brand_id ORDER BY products.product_id DESC', $offset, $no_of_records_per_page) as $row) {
                ?>
                    <tr id="product_<?= $row['product_id']; ?>">
                        <td><?= $row['product_id']; ?></td>
                        <td><img src="../uploads/products/<?= $row['product_thumbnail'] ?>" width="100px"></td>
                        <td>
                            <p class="mb-0"><?= $row['product_title']; ?></p>
                            <small class="text-primary"><?= $row['category_name'] ?></small>
                            <small class="text-success"><?= $row['brand_name'] ?></small>
                        </td>
                        <td><?= $row['regular_price'] ?></td>
                        <td><?= $row['selling_price'] ?></td>
                        <td><?= $row['short_description'] ?></td>
                        <td><?= $row['long_description'] ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td><button type="button" class="btn btn-primary shadow-none edit" id="<?= $row['product_id']; ?>"><i class="fas fa-edit"></i></button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-danger shadow-none delete" data-id="<?= $row['product_id']; ?>"><i class="fas fa-trash"></i></button>
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
            $total_pages = $obj->pagination('products', $no_of_records_per_page);
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
        $(document).on('submit', '#product_form', function(e) {
            e.preventDefault();
            var fd = new FormData(this);
            $.ajax({
                url: 'action/product_action.php',
                type: 'POST',
                data: fd,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 0) {
                        $("#error").html(response.msg_error);
                    }
                    if (response.status == 1) {
                        $("#product_form")[0].reset();
                        $("#productModal").modal('hide');
                        $("#error").html('');
                        location.reload();
                    }
                },
            });
        });
    });
</script>