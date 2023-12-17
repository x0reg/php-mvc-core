<?php include_once(__DIR__ . "./layout/header.php");  ?>

<body class=" font-inter dashcode-app" id="body_class" style="width: 100%; height: 100px;background: linear-gradient(to right, #FF69B4, #EE82EE);">
    <!-- [if IE]> <p class="browserupgrade"> You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security. </p> <![endif] -->
    <main class="app-wrapper">
        <!-- BEGIN: Sidebar -->
        <?php include_once(__DIR__ . "./layout/sidebar.php");  ?>
        <!-- End: Sidebar -->

        <div class="flex flex-col justify-between min-h-screen">
            <div>
                <!-- BEGIN: Header -->
                <!-- BEGIN: Header -->
                <?php require_once(__DIR__ . "./layout/nav.php");  ?>
                <!-- END: Header -->
                <!-- END: Header -->
                <div class="content-wrapper transition-all duration-150 ltr:ml-[248px] rtl:mr-[248px]" id="content_wrapper">
                    <div class="page-content">
                        <div class="transition-all duration-150 container-fluid" id="page_layout">
                            <div id="content_layout">

                                <div class="flex justify-between flex-wrap items-center mb-6">
                                    <h4 class="font-medium lg:text-2xl text-xl capitalize text-slate-900 inline-block ltr:pr-4 rtl:pl-4 mb-4 sm:mb-0 flex space-x-3 rtl:space-x-reverse">
                                    </h4>
                                    <div class="flex sm:space-x-4 space-x-2 sm:justify-end items-center rtl:space-x-reverse">

                                    </div>
                                </div>

                                <div class="grid lg:grid-cols-12 md:grid-cols-12 sm:grid-cols-12 grid-cols-1 gap-5">
                                    <div class="bg-slate-900 dark:bg-slate-800 mb-10 mt-7 p-4 relative text-center rounded-2xl text-danger" style="background-color: rgb(255 255 255 / var(--tw-bg-opacity));">
                                        <img src="/public/images/svg/rabit.svg" alt="" class="mx-auto relative -mt-[73px]">
                                        <div class="max-w-[560px] mx-auto mt-5">
                                            <div class="widget-title">
                                                <h5>Hệ thống Game Telegram - Uy tín số 1 Việt Nam</h5>
                                            </div>
                                            <div class="text-xs font-normal">
                                                Giao dịch tự động 24/7 - Trả thưởng 30s
                                            </div>

                                        </div>
                                        <div class="mt-6">
                                            <button class="btn bg-white hover:bg-opacity-80 text-slate-900 btn-sm w-full block btn-primary">
                                                Box chat telegram
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-12 gap-5">
                                    <div class="xl:col-span-6 col-span-12">
                                        <div class="card active">
                                            <div class="ccard-body flex flex-col rounded-md bg-white dark:bg-slate-800 shadow-base menu-open">
                                                <div class="items-center p-5">
                                                    <h3 class="card-title text-slate-900 dark:text-white text-center ">KHÔ MÁU THÔI ANH EM</h3>
                                                    <hr class="my-3">
                                                    <div class="card-body p-0">
                                                        <!-- BEGIN: Customer Card -->
                                                        <div>
                                                            <ul class="nav nav-pills flex gap-4 justify-center flex-wrap" id="pills-tabHorizontal" role="tablist">
                                                                <li class="nav-item text-center" role="presentation">
                                                                    <button class="nav-link active btn inline-flex justify-center btn-primary btn-sm" id="pills-home-tabHorizontal" data-bs-toggle="pill" data-bs-target="#game-chanLe" role="tab" aria-controls="game-chanLe" aria-selected="true">Chẵn Lẻ</button>
                                                                </li>

                                                                <li class="nav-item text-center" role="presentation">
                                                                    <button href="#pills-contactHorizontal" class="nav-link block btn inline-flex justify-center btn-primary btn-sm" id="pills-contact-tabHorizontal" data-bs-toggle="pill" data-bs-target="#game-taiXiu" role="tab" aria-controls="game-taiXiu" aria-selected="false">Tài Xỉu</a>
                                                                </li>

                                                            </ul>
                                                            <hr class="my-3">
                                                            <div class="tab-content" id="pills-tabContentHorizontal">

                                                                <!-- tab game chẵn lẻ-->
                                                                <div class="tab-pane fade show active" id="game-chanLe" role="tabpanel" aria-labelledby="pills-home-tabHorizontal">
                                                                    <div class="flex flex-col gap-5">
                                                                        <p>Kết quả dựa vào <strong>Xúc Xắc Telegram. bên mình không can thiệp vào Kết quả được nhé. Tất cả KQ được thông báo tại BOX TELEGRAM</strong></p>
                                                                        <div class="flex flex-col gap-4">
                                                                            <div class="flex flex-col gap-1">
                                                                                <label class="block font-medium text-secondary-700 dark:text-secondary-400">Chọn
                                                                                    nội dung cược :</label>
                                                                                <div class="grid grid-cols-2 gap-4 mt-1">
                                                                                    <div class="game">
                                                                                        <input id="gameCL_C" value="C" type="radio" name="game-value-selection" class="hidden peer" data-url="api/chanle">
                                                                                        <label for="gameCL_C" class="transition inline-flex peer-checked:hidden items-center w-full p-4 border-2 rounded-lg cursor-pointer group border-secondary-200/70 bg-white text-secondary-600">
                                                                                            <div class="flex w-full flex-col justify-start gap-2">
                                                                                                <div class="flex justify-between">
                                                                                                    <div class="w-full font-bold">Chẵn</div>
                                                                                                    <span class="font-bold">x<?= $ratioChan["ratio"] ?></span>
                                                                                                </div>
                                                                                                <div class="w-full text-sm flex gap-2 opacity-60">

                                                                                                    <span class="outline-none inline-flex justify-center items-center group rounded-full w-6 h-6 text-white bg-secondary-500 dark:bg-secondary-700">
                                                                                                        2
                                                                                                    </span>
                                                                                                    <span class="outline-none inline-flex justify-center items-center group rounded-full w-6 h-6 text-white bg-secondary-500 dark:bg-secondary-700">
                                                                                                        4

                                                                                                    </span>
                                                                                                    <span class="outline-none inline-flex justify-center items-center group rounded-full w-6 h-6 text-white bg-secondary-500 dark:bg-secondary-700">
                                                                                                        6

                                                                                                    </span>

                                                                                                </div>
                                                                                            </div>
                                                                                        </label>
                                                                                    </div>

                                                                                    <div class="game">
                                                                                        <input id="gameCL_L" value="L" type="radio" name="game-value-selection" class="hidden peer" data-url="api/chanle">
                                                                                        <label for="gameCL_L" class="transition inline-flex peer-checked:hidden items-center w-full p-4 border-2 rounded-lg cursor-pointer group border-secondary-200/70 bg-white text-secondary-600">
                                                                                            <div class="flex w-full flex-col justify-start gap-2">
                                                                                                <div class="flex justify-between">
                                                                                                    <div class="w-full font-bold">Lẻ</div>
                                                                                                    <span class="font-bold">x<?= $ratioLe["ratio"] ?></span>
                                                                                                </div>
                                                                                                <div class="w-full text-sm flex gap-2 opacity-60">
                                                                                                    <span class="outline-none inline-flex justify-center items-center group rounded-full w-6 h-6 text-white bg-secondary-500 dark:bg-secondary-700">
                                                                                                        1
                                                                                                    </span>
                                                                                                    <span class="outline-none inline-flex justify-center items-center group rounded-full w-6 h-6 text-white bg-secondary-500 dark:bg-secondary-700">
                                                                                                        3
                                                                                                    </span>
                                                                                                    <span class="outline-none inline-flex justify-center items-center group rounded-full w-6 h-6 text-white bg-secondary-500 dark:bg-secondary-700">
                                                                                                        5
                                                                                                    </span>


                                                                                                </div>
                                                                                            </div>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <br>
                                                                                <?php include(__DIR__ . "/layout/buttonAmount.php") ?>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <hr class="my-5">
                                                                    <center>
                                                                        <button id="submitButtonAjax" data-url="/api/play-game" class="submitButton btn inline-flex justify-center btn-primary rounded-[25px]">
                                                                            <span class="flex items-center">
                                                                                <iconify-icon class="text-xl ltr:mr-2 rtl:ml-2" icon="heroicons-outline:newspaper"></iconify-icon>
                                                                                <span>XÁC NHẬN ĐẶT CƯỢC</span>
                                                                            </span>
                                                                        </button>
                                                                    </center>
                                                                </div>



                                                                <!-- tab game TÀI XỈU-->
                                                                <div class="tab-pane fade" id="game-taiXiu" role="tabpanel" aria-labelledby="pills-contact-tabHorizontal">
                                                                    <div class="flex flex-col gap-5">
                                                                        <p>Kết quả dựa vào <strong>Xúc Xắc Telegram. bên mình không can thiệp vào Kết quả được nhé. Tất cả KQ được thông báo tại BOX TELEGRAM</strong></p>
                                                                        <div class="flex flex-col gap-4">
                                                                            <div class="flex flex-col gap-1">
                                                                                <label class="block font-medium text-secondary-700 dark:text-secondary-400">Chọn
                                                                                    nội dung cược :</label>
                                                                                <div class="grid grid-cols-2 gap-4 mt-1">
                                                                                    <div class="relative">
                                                                                        <input id="gameTX_T" value="T" type="radio" name="game-value-selection" class="hidden peer" data-url="api/taixiu">
                                                                                        <label for="gameTX_T" class="transition inline-flex peer-checked:hidden items-center w-full p-4 border-2 rounded-lg cursor-pointer group border-secondary-200/70 bg-white text-secondary-600">
                                                                                            <div class="flex w-full flex-col justify-start gap-2">
                                                                                                <div class="flex justify-between">
                                                                                                    <div class="w-full font-bold">Tài</div>
                                                                                                    <span class="font-bold ">x<?= $ratioTai["ratio"] ?></span>
                                                                                                </div>
                                                                                                <div class="w-full text-sm flex gap-2 opacity-60">
                                                                                                    <span class="outline-none inline-flex justify-center items-center group rounded-full w-6 h-6 text-white bg-secondary-500 dark:bg-secondary-700">
                                                                                                        4
                                                                                                    </span>
                                                                                                    <span class="outline-none inline-flex justify-center items-center group rounded-full w-6 h-6 text-white bg-secondary-500 dark:bg-secondary-700">
                                                                                                        5
                                                                                                    </span>
                                                                                                    <span class="outline-none inline-flex justify-center items-center group rounded-full w-6 h-6 text-white bg-secondary-500 dark:bg-secondary-700">
                                                                                                        6
                                                                                                    </span>


                                                                                                </div>
                                                                                            </div>
                                                                                        </label>
                                                                                    </div>

                                                                                    <div class="relative">
                                                                                        <input id="gameTX_X" value="X" type="radio" name="game-value-selection" class="hidden peer" data-url="api/taixiu">
                                                                                        <label for="gameTX_X" class="transition inline-flex peer-checked:hidden items-center w-full p-4 border-2 rounded-lg cursor-pointer group border-secondary-200/70 bg-white text-secondary-600">
                                                                                            <div class="flex w-full flex-col justify-start gap-2">
                                                                                                <div class="flex justify-between">
                                                                                                    <div class="w-full font-bold">Xỉu</div>
                                                                                                    <span class="font-bold">x<?= $ratioXiu["ratio"] ?></span>
                                                                                                </div>
                                                                                                <div class="w-full text-sm flex gap-2 opacity-60">
                                                                                                    <span class="outline-none inline-flex justify-center items-center group rounded-full w-6 h-6 text-white bg-secondary-500 dark:bg-secondary-700">
                                                                                                        1
                                                                                                    </span>
                                                                                                    <span class="outline-none inline-flex justify-center items-center group rounded-full w-6 h-6 text-white bg-secondary-500 dark:bg-secondary-700">
                                                                                                        2
                                                                                                    </span>
                                                                                                    <span class="outline-none inline-flex justify-center items-center group rounded-full w-6 h-6 text-white bg-secondary-500 dark:bg-secondary-700">
                                                                                                        3
                                                                                                    </span>

                                                                                                </div>
                                                                                            </div>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <br>
                                                                                <?php include(__DIR__ . "/layout/buttonAmount.php") ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <hr class="my-5">
                                                                    <center>
                                                                        <button id="submitButtonAjax" data-url="/api/play-game" class="submitButton btn inline-flex justify-center btn-primary rounded-[25px]">
                                                                            <span class="flex items-center">
                                                                                <iconify-icon class="text-xl ltr:mr-2 rtl:ml-2" icon="heroicons-outline:newspaper"></iconify-icon>
                                                                                <span>XÁC NHẬN ĐẶT CƯỢC</span>
                                                                            </span>
                                                                        </button>
                                                                    </center>
                                                                </div>
                                                                <!-- tab game GIFTCODE-->
                                                                <div class="tab-pane fade" id="ma-giftCode" role="tabpanel" aria-labelledby="pills-settings-tabHorizontal">

                                                                    <h5 class="text-center">💸 Nhập Mã Giftcode 💸</h5>
                                                                    <div class="input-area">

                                                                        <input id="giftcode" type="text" class="form-control !text-lg" placeholder="Mã code nhận được từ event">
                                                                    </div>
                                                                    <hr class="my-5">
                                                                    <center>
                                                                        <button data-url="/api/giftcode" id="submitButtonAjax" class="submitButtonGiftCode btn inline-flex justify-center btn-primary rounded-[25px]">
                                                                            <span class="flex items-center">
                                                                                <iconify-icon class="text-xl ltr:mr-2 rtl:ml-2" icon="heroicons-outline:newspaper"></iconify-icon>
                                                                                <span>XÁC NHẬN</span>
                                                                            </span>
                                                                        </button>
                                                                    </center>
                                                                </div>


                                                            </div>
                                                        </div>
                                                        <!-- END: Customer Card -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="xl:col-span-6 col-span-12">
                                        <div class="card active">
                                            <div class="card-body rounded-md bg-white dark:bg-slate-800 shadow-base menu-open">
                                                <div class="items-center text-center p-5">
                                                    <h3 class="card-title text-slate-900 dark:text-white">THỐNG KÊ</h3>
                                                    <hr class="my-3">
                                                    <div class="card-body p-0">
                                                        <!-- BEGIN: Customer Card -->
                                                        <div>
                                                            <ul class="nav nav-pills flex gap-4 justify-center flex-wrap" id="pills-tabHorizontal" role="tablist">

                                                                <li class="nav-item text-center" role="presentation">
                                                                    <button href="#pills-profileHorizontal" class="nav-link active btn inline-flex justify-center btn-danger btn-sm" id="pills-profile-tabHorizontal" data-bs-toggle="pill" data-bs-target="#lich-su-choi" role="tab" aria-controls="lich-su-choi" aria-selected="false">Lịch Sử Chơi</button>
                                                                </li>

                                                                <li class="nav-item text-center" role="presentation">
                                                                    <button href="#pills-settingsHorizontal" class="nav-link block btn inline-flex justify-center btn-danger btn-sm" id="pills-settings-tabHorizontal" data-bs-toggle="pill" data-bs-target="#lich-su-giftcode" role="tab" aria-controls="lich-su-giftcode" aria-selected="false">Nhiệm Vụ Ngày</a>
                                                                </li>
                                                            </ul>
                                                            <hr class="my-3">
                                                            <div class="tab-content" id="pills-tabContentHorizontal">

                                                                <!-- tab lịch sử chơi -->
                                                                <div class="tab-pane fade show active" id="lich-su-choi" role="tabpanel" aria-labelledby="pills-profile-tabHorizontal">
                                                                    <div class="flex flex-col gap-5">
                                                                        <p><strong>LỊCH SỬ CHƠI GAME.</strong></p>
                                                                        <div class="card">
                                                                            <div class="card-body px-6 pb-6">
                                                                                <div class="overflow-x-auto -mx-6">
                                                                                    <div class="inline-block min-w-full align-middle">
                                                                                        <div class="overflow-hidden ">
                                                                                            <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                                                                                <thead class="bg-slate-200 dark:bg-slate-700">
                                                                                                    <tr>
                                                                                                        <th scope="col" class=" table-th " style="text-align: center;">
                                                                                                            Game
                                                                                                        </th>

                                                                                                        <th scope="col" class=" table-th " style="text-align: center;">
                                                                                                            Mã GD
                                                                                                        </th>

                                                                                                        <th scope="col" class=" table-th " style="text-align: center;">
                                                                                                            Nội DUng
                                                                                                        </th>

                                                                                                        <th scope="col" class=" table-th " style="text-align: center;">
                                                                                                            Xu Cược
                                                                                                        </th>
                                                                                                        <th scope="col" class=" table-th " style="text-align: center;">
                                                                                                            Xu Nhận
                                                                                                        </th>
                                                                                                        <th scope="col" class=" table-th " style="text-align: center;">
                                                                                                            Trạng Thái
                                                                                                        </th>

                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                                                                                    <?php foreach ($getPlayByUsername as $getPlayByUsernames) { ?>
                                                                                                        <tr class="hover:bg-slate-200 dark:hover:bg-slate-700">
                                                                                                            <td class="table-td"><?= $getPlayByUsernames["game"] ?></td>
                                                                                                            <td class="table-td"><?= $getPlayByUsernames["trand_id"] ?></td>
                                                                                                            <td class="table-td"><?= $getPlayByUsernames["comment"] ?></td>
                                                                                                            <td class="table-td"><?= customNumberFormat($getPlayByUsernames["amount"]) ?></td>
                                                                                                            <td class="table-td"><?= customNumberFormat($getPlayByUsernames["received_amount"]) ?></td>
                                                                                                            <td class="table-td"><?= statusPlayGame($getPlayByUsernames["status"]) ?></td>
                                                                                                        </tr>
                                                                                                    <?php } ?>

                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                                <!-- tab Nhiệm vụ ngày-->
                                                                <div class="tab-pane fade" id="lich-su-giftcode" role="tabpanel" aria-labelledby="pills-settings-tabHorizontal">
                                                                    <p><strong>Nhiệm Vụ Ngày</strong></p>
                                                                    <div class="card">
                                                                        <div class="card-body px-6 pb-6">
                                                                            <div class="overflow-x-auto -mx-6">
                                                                                <div class="inline-block min-w-full align-middle">
                                                                                    <div class="overflow-hidden ">
                                                                                        <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                                                                            <thead class="bg-slate-200 dark:bg-slate-700">
                                                                                                <tr>
                                                                                                    <th scope="col" class=" table-th " style="text-align: center;">
                                                                                                        Mã Giftcode
                                                                                                    </th>

                                                                                                    <th scope="col" class=" table-th " style="text-align: center;">
                                                                                                        Quà tặng
                                                                                                    </th>

                                                                                                    <th scope="col" class=" table-th " style="text-align: center;">
                                                                                                        Thời Gian
                                                                                                    </th>


                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                                                                                                <tr class="hover:bg-slate-200 dark:hover:bg-slate-700">
                                                                                                    <td class="table-td">123123</td>

                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                        <!-- END: Customer Card -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="xl:col-span-6 col-span-12">
                                        <div class="card ">
                                            <div class="items-center text-center p-5">
                                                <h3 class="card-title text-slate-900 dark:text-white">LỊCH SỬ ĐẶT CƯỢC</h3>
                                            </div>
                                            <div class="card-body p-0">
                                                <!-- BEGIN: Products -->
                                                <div class="card">
                                                    <div class="card-body px-6 pb-6">
                                                        <div class="overflow-x-auto -mx-6">
                                                            <div class="inline-block min-w-full align-middle">
                                                                <div class="overflow-hidden ">
                                                                    <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                                                        <thead class="bg-slate-200 dark:bg-slate-700">
                                                                            <tr>
                                                                                <th scope="col" class=" table-th " style="text-align: center;">
                                                                                    Username
                                                                                </th>

                                                                                <th scope="col" class=" table-th " style="text-align: center;">
                                                                                    Game
                                                                                </th>


                                                                                <th scope="col" class=" table-th " style="text-align: center;">
                                                                                    Xu Cược
                                                                                </th>
                                                                                <th scope="col" class=" table-th " style="text-align: center;">
                                                                                    Xu Nhận
                                                                                </th>
                                                                                <th scope="col" class=" table-th " style="text-align: center;">
                                                                                    Trạng Thái
                                                                                </th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                                                            <?php foreach ($getAllDataHistory as $key => $getAllDataHistorys) { ?>
                                                                                <tr class="hover:bg-slate-200 dark:hover:bg-slate-700">
                                                                                    <td class="table-td"><?= catUsername($getAllDataHistorys["username"]) ?></td>


                                                                                    <td class="table-td"><?= $getAllDataHistorys["game"] ?></td>





                                                                                    <td class="table-td"><?= customNumberFormat($getAllDataHistorys["amount"]) ?></td>


                                                                                    <td class="table-td"><?= customNumberFormat($getAllDataHistorys["received_amount"]) ?></td>


                                                                                    <td class="table-td"><?= statusPlayGame($getAllDataHistorys["status"]) ?></td>

                                                                                </tr>
                                                                            <?php } ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END: Product -->

                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include_once(__DIR__ . "./layout/nav-mobile.php");  ?>
        </div>
    </main>

    <?php include_once(__DIR__ . "./layout/footer.php");  ?>
    <script>
        $(document).ready(function() {
            // Bắt sự kiện khi người dùng click vào nút 'addAmount' trong tất cả các tabs
            $('.addAmount').on('click', function() {
                var dataAmount = parseInt($(this).data('amount'));
                var $input = $(this).closest('.tab-pane').find('#amount');
                var currentValue = parseFloat($input.val().replace(/\./g, '')) || 0;

                currentValue += dataAmount;
                $input.val(currentValue.toLocaleString('vi-VN'));
            });

            $(document).on('click', '#clearButton', function() {
                var $input = $(this).closest('.tab-pane').find('#amount');
                $input.val('');
            });

            $(document).on('input', '.tab-pane input#amount', function() {
                var inputValue = $(this).val();
                inputValue = inputValue.replace(/\./g, '');
                inputValue = parseFloat(inputValue);

                if (isNaN(inputValue)) {
                    $(this).val('');
                } else {
                    inputValue = inputValue.toLocaleString('vi-VN');
                    $(this).val(inputValue);
                }
            });

        });

        ////ajax
        $(document).ready(function() {
            $(".submitButton").on("click", function() {
                var selectedNoiDungCuoc = $("input[type='radio']:checked").val();
                var url = $(this).data('url');
                var activeTabId = $('.tab-pane.active').attr('id');
                var amountValue = $('#' + activeTabId + ' #amount').val();
                var button = $(this).text();
                // console.log("Giá trị đã chọn: " + amountValue);
                // return;
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        noidung: selectedNoiDungCuoc,
                        money: amountValue,
                    },
                    beforeSend: function() {
                        $(".submitButton").prop("disabled", true).html('Đang xử lý...');
                    },
                    complete: function() {
                        $(".submitButton").prop("disabled", false).html('<iconify-icon class="text-xl ltr:mr-2 rtl:ml-2" icon="heroicons-outline:newspaper"></iconify-icon>' + button);
                    },
                    success: function(data) {
                        if (data.status == "game") {
                            Swal.fire('Thông Báo', data.message, "error");
                        } else if (data.status == 'error') {
                            Swal.fire('Thông Báo', data.message, "error");
                        } else {
                            Swal.fire('Thông Báo', data.message, data.status);
                        }
                    },
                    error: function(error) {
                        console.log("Lỗi: " + error);
                    }
                });
            });
        });


        ////pusher

        var pusher = new Pusher('77c2a37e9785661ad4ab', {
            cluster: 'ap1',
            encrypted: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind(<?= getSessionUser() ?>, function(data) {
            customAlert();
        });

        function customAlert() {
            let timerInterval;
            Swal.fire({
                title: "ĐANG QUAY THƯỞNG",
                timer: 4000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 10);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                }
            });
        }
    </script>

    </html>