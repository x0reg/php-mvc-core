<?php require_once(__DIR__ . "/layout/head.php") ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/public/admin/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <?php require_once(__DIR__ . "/layout/navbar.php") ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php require_once(__DIR__ . "/layout/sidebar.php") ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Thống Kê Thành Viên</h1>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Danh sách thành viên</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="datatables1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Số Dư</th>
                                                <th>Tổng Doanh Thu</th>
                                                <th>Tổng 7 Ngày</th>
                                                <th>Hôm nay</th>
                                                <th>Ngày <?= date("d-m", strtotime("-1 days")) ?></th>
                                                <th>Ngày <?= date("d-m", strtotime("-2 days")) ?></th>
                                                <th>Ngày <?= date("d-m", strtotime("-3 days")) ?></th>
                                                <th>Ngày <?= date("d-m", strtotime("-4 days")) ?></th>
                                                <th>Ngày <?= date("d-m", strtotime("-5 days")) ?></th>
                                                <th>Ngày <?= date("d-m", strtotime("-6 days")) ?></th>
                                                <th>Chức năng</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>

                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>

                </div><!-- /.container-fluid -->

            </section>
            <!-- /.content -->
        </div>

    </div>
    <!-- ./wrapper -->
    <?php require_once(__DIR__ . "/layout/footer.php") ?>

</body>
<script>
    $(document).ready(function() {
        $("#datatables1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "processing": true,
            // "serverSide": true,
            "ajax": {
                "url": "/admin/get-list-user", // Thay thế bằng đường dẫn tới API hoặc script lấy dữ liệu của bạn
                "type": "POST",
                "dataSrc": "data"
            },
            "columns": [{
                    "data": "username"
                },
                {
                    "data": "money"
                },
                {
                    "data": "tongdoanhthu"
                },
                {
                    "data": "tongdoanhthu7ngay"
                },
                {
                    "data": "ngayhomnay"
                },
                {
                    "data": "motngaytruoc"
                },
                {
                    "data": "haingaytruoc"
                },
                {
                    "data": "bangaytruoc"
                },
                {
                    "data": "bonngaytruoc"
                },
                {
                    "data": "namngaytruoc"
                },
                {
                    "data": "saungaytruoc"
                },
                {
                    "data": "addColums"
                }
            ],
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#datatables1_wrapper .col-md-6:eq(0)');

    });
</script>

</html>