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
                            <h1 class="m-0">Thống Kê WEBSITE</h1>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-header border-0">
                                    <h3 class="card-title">Thống Kê ALL</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                        <p class="text-success text-xl">
                                            <i class="ion ion-ios-refresh-empty"></i>
                                        </p>
                                        <p class="d-flex flex-column text-right">
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($getAllTongNhan) ?> xu
                                            </span>
                                            <span class="text-muted">Tổng Tiền Đã Nhận</span>
                                        </p>
                                    </div>
                                    <!-- /.d-flex -->
                                    <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                        <p class="text-warning text-xl">
                                            <i class="ion ion-ios-cart-outline"></i>
                                        </p>
                                        <p class="d-flex flex-column text-right">
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($getAllTongTra) ?> xu
                                            </span>
                                            <span class="text-muted">Tổng Tiền Đã Trả</span>
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($allNVHN) ?> xu
                                            </span>
                                            <span class="text-muted">Xu Trả NVHN</span>
                                        </p>
                                    </div>
                                    <!-- /.d-flex -->
                                    <div class="d-flex justify-content-between align-items-center mb-0">
                                        <p class="text-danger text-xl">
                                            <i class="ion ion-ios-people-outline"></i>
                                        </p>
                                        <p class="d-flex flex-column text-right">
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($doanhthuall) ?> xu
                                            </span>
                                            <span class="text-muted">Doanh Thu</span>
                                        </p>
                                    </div>
                                    <!-- /.d-flex -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-header border-0">

                                    <h3 class="card-title">Thống Kê Tháng trước / Tháng này</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                        <p class="text-success text-xl">
                                            <i class="ion ion-ios-refresh-empty"></i>
                                        </p>
                                        <p class="d-flex flex-column text-right">
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($getTotalAmountRechargeMonththangtruoc) ?>/ <?= customNumberFormat($getTotalAmountRechargeMonth) ?> xu
                                            </span>
                                            <span class="text-muted">Tổng Tiền Đã Nhận</span>
                                        </p>
                                    </div>
                                    <!-- /.d-flex -->
                                    <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                        <p class="text-warning text-xl">
                                            <i class="ion ion-ios-cart-outline"></i>
                                        </p>
                                        <p class="d-flex flex-column text-right">
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($getTotalAmountWithdrawMonththangtruoc) ?> / <?= customNumberFormat($getTotalAmountWithdrawMonth) ?> xu
                                            </span>
                                            <span class="text-muted">Tổng Tiền Đã Trả</span>
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($getTotalAmountNVHNMonththangtruoc) ?>/<?= customNumberFormat($getTotalAmountNVHNMonth) ?> xu
                                            </span>
                                            <span class="text-muted">Xu Trả NVHN</span>
                                        </p>
                                    </div>
                                    <!-- /.d-flex -->
                                    <div class="d-flex justify-content-between align-items-center mb-0">
                                        <p class="text-danger text-xl">
                                            <i class="ion ion-ios-people-outline"></i>
                                        </p>
                                        <p class="d-flex flex-column text-right">
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($doanhthumonththangtruoc) ?> / <?= customNumberFormat($doanhthumonth) ?> xu
                                            </span>
                                            <span class="text-muted">Doanh Thu</span>
                                        </p>
                                    </div>
                                    <!-- /.d-flex -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-header border-0">
                                    <h3 class="card-title">Thống Kê Tuần Trước / Tuần này</h3>

                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                        <p class="text-success text-xl">
                                            <i class="ion ion-ios-refresh-empty"></i>
                                        </p>
                                        <p class="d-flex flex-column text-right">
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($getTotalAmountRechargeWeektuantruoc) ?>/<?= customNumberFormat($getTotalAmountRechargeWeek) ?>
                                            </span>
                                            <span class="text-muted">Tổng Xu Đã Nhận</span>
                                        </p>
                                    </div>
                                    <!-- /.d-flex -->
                                    <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                        <p class="text-warning text-xl">
                                            <i class="ion ion-ios-cart-outline"></i>
                                        </p>
                                        <p class="d-flex flex-column text-right">
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($getTotalAmountWithDrawWeektuantruoc) ?>/ <?= customNumberFormat($getTotalAmountWithDrawWeek) ?> xu
                                            </span>
                                            <span class="text-muted">Tổng Xu đã rút</span>
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($getTotalAmountNVHNWeektuantruoc) ?> /<?= customNumberFormat($getTotalAmountNVHNWeek) ?> xu
                                            </span>
                                            <span class="text-muted">Xu trả NVHN</span>
                                        </p>
                                    </div>
                                    <!-- /.d-flex -->
                                    <div class="d-flex justify-content-between align-items-center mb-0">
                                        <p class="text-danger text-xl">
                                            <i class="ion ion-ios-people-outline"></i>
                                        </p>
                                        <p class="d-flex flex-column text-right">
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($doanhthutuantruoc) ?>/ <?= customNumberFormat($doanhthutuan) ?> xu
                                            </span>
                                            <span class="text-muted">Doanh Thu</span>
                                        </p>
                                    </div>
                                    <!-- /.d-flex -->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-header border-0">
                                    <h3 class="card-title">Thống Kê Hôm qua / Hôm Nay</h3>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-sm btn-tool">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-tool">
                                            <i class="fas fa-bars"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                        <p class="text-success text-xl">
                                            <i class="ion ion-ios-refresh-empty"></i>
                                        </p>
                                        <p class="d-flex flex-column text-right">
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($totalAmoutRechargengaytruoc) ?> /<?= customNumberFormat($totalAmoutRecharge) ?> xu
                                            </span>
                                            <span class="text-muted">Tổng Nhận</span>
                                        </p>
                                    </div>
                                    <!-- /.d-flex -->
                                    <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                        <p class="text-warning text-xl">
                                            <i class="ion ion-ios-cart-outline"></i>
                                        </p>
                                        <p class="d-flex flex-column text-right">
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($totalAmountWithDrawngaytruoc) ?>/<?= customNumberFormat($totalAmountWithDraw) ?> xu
                                            </span>
                                            <span class="text-muted">Tổng Rút</span>
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($getTotalAmountNVHNngaytruoc) ?>/<?= customNumberFormat($getTotalAmountNVHN) ?> xu
                                            </span>
                                            <span class="text-muted">Xu Trả Nhiệm Vụ</span>
                                        </p>
                                    </div>
                                    <!-- /.d-flex -->
                                    <div class="d-flex justify-content-between align-items-center mb-0">
                                        <p class="text-danger text-xl">
                                            <i class="ion ion-ios-people-outline"></i>
                                        </p>
                                        <p class="d-flex flex-column text-right">
                                            <span class="font-weight-bold">
                                                <?= customNumberFormat($doanhthutodayngaytruoc) ?> / <?= customNumberFormat($doanhthutoday) ?> xu
                                            </span>
                                            <span class="text-muted">Doanh Thu</span>
                                        </p>
                                    </div>
                                    <!-- /.d-flex -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3><?= customNumberFormat($getTotalAmountUser) ?></h3>

                                    <p>Tổng Số Dư User</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>

                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?= customNumberFormat($getTotalUser) ?></h3>

                                    <p>Tổng Số Thành Viên</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?= customNumberFormat($totalAmountWithDraw) ?></h3>
                                    <p>Xu rút hôm nay</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?= customNumberFormat($totalAmoutRecharge) ?></h3>
                                    <p>Xu nạp hôm nay</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?= customNumberFormat($getTotalPlayToday) ?></h3>
                                    <p>Số lần chơi hôm nay</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?= customNumberFormat($getTotalUserPlayToday) ?></h3>
                                    <p>Số người chơi hôm nay</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Lịch Sử Chơi</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Username</th>
                                                <th>Game</th>
                                                <th>MGD</th>
                                                <th>Điểm XX</th>
                                                <th>Tiền Cược</th>
                                                <th>Tiền Nhận</th>
                                                <th>Trạng Thái</th>
                                                <th>Thời Gian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($getAllDataHistory as $key => $getAllDataHistorys) { ?>
                                                <tr>
                                                    <td><?= $getAllDataHistorys["id"] ?></td>
                                                    <td><?= $getAllDataHistorys["username"] ?></td>
                                                    <td><?= $getAllDataHistorys["game"] ?></td>
                                                    <td><?= $getAllDataHistorys["trand_id"] ?></td>
                                                    <td><?= $getAllDataHistorys["value_dice"] ?></td>
                                                    <td><?= customNumberFormat($getAllDataHistorys["amount"]) ?></td>
                                                    <td><?= customNumberFormat($getAllDataHistorys["received_amount"]) ?></td>
                                                    <td><?= statusPlayGameAdmin($getAllDataHistorys["status"]) ?></td>
                                                    <td><?= $getAllDataHistorys["created_at"] ?></td>
                                                </tr>
                                            <?php  } ?>

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

</html>