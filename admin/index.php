<?php
require_once "includes/header.php";
?>
<!-- this is our working panel -->
<section class="working-panel">
    <div class="container-fluid">
        <h1 class="display-4">Welcome to Dashboard</h1>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-orange-g text-white">
                    <div class="card-body">
                        <h4 class="fw-light"><i class="fas fa-dolly"></i> All Category</h4>
                        <hr>
                        <h5>
                            <b>12345</b>
                        </h5>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-green-g text-white">
                    <div class="card-body">
                        <h4 class="fw-light"><i class="fas fa-dolly-flatbed"></i> All Brands</h4>
                        <hr>
                        <h5>
                            <b>5465</b>
                        </h5>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-primary-g text-white">
                    <div class="card-body">
                        <h4 class="fw-light"><i class="fas fa-users"></i> All Users</h4>
                        <hr>
                        <h5>
                            <b>1500</b>
                        </h5>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-golden-g text-white">
                    <div class="card-body">
                        <h4 class="fw-light"><i class="fas fa-truck"></i> All Orders</h4>
                        <hr>
                        <h5>
                            <b>1500</b>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- all new orders table -->
        <div class="all-order mt-5">
            <table class="table table-bordered table-hover">
                <h2>New Orders</h2>
                <hr>
                <thead class="bg-primary text-white">
                    <tr>
                        <th scope="col">Order no.</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Date</th>
                        <th scope="col">Paid Status</th>
                        <th scope="col">Order Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>3</td>
                        <td>23-08-2020</td>
                        <td><span class="badge bg-success">Paid</span></td>
                        <td><span class="badge bg-success">Completed</span></td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Mark</td>
                        <td>2</td>
                        <td>24-08-2020</td>
                        <td><span class="badge bg-danger">Unpaid</span></td>
                        <td><span class="badge bg-info">Processing</span></td>
                    </tr>
                </tbody>
            </table>
            <div class="order-pagination">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<?php
require_once "includes/footer.php";
?>