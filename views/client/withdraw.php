<?php include_once(__DIR__ . "/layout/header.php"); ?>


<body class=" font-inter dashcode-app" id="body_class" style="width: 100%; height: 100px;background: linear-gradient(to right, #FF69B4, #EE82EE);">
    <!-- [if IE]> <p class="browserupgrade"> You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security. </p> <![endif] -->
    <main class="app-wrapper">
        <!-- BEGIN: Sidebar -->
        <?php include_once(__DIR__ . "/layout/sidebar.php"); ?>
        <!-- End: Sidebar -->

        <div class="flex flex-col justify-between min-h-screen">
            <div>
                <!-- BEGIN: Header -->
                <!-- BEGIN: Header -->
                <?php include_once(__DIR__ . "/layout/nav.php"); ?>
                <!-- END: Header -->
                <!-- END: Header -->
                <div class="content-wrapper transition-all duration-150 ltr:ml-[248px] rtl:mr-[248px]" id="content_wrapper">
                    <div class="page-content">
                        <div class="transition-all duration-150 container-fluid" id="page_layout">
                            <div id="content_layout">

                                <div class="grid xl:grid-cols-2 grid-cols-1 gap-6">
                                    <div class="card">
                                        <div class="card-body flex flex-col p-6">
                                            <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                                                <div class="flex-1">
                                                    <div class="card-title text-slate-900 dark:text-white">Rút Xu Tự Động</div>
                                                </div>
                                            </header>
                                            <form action="/api/withdraw" method="post" id="ajaxSubmitForm">
                                                <div class="card-text h-full space-y-4">
                                                    <div class="input-area">
                                                        Nhập STK nhận tiền :
                                                        <div class="relative">
                                                            <input type="text" name="account_number" class="form-control !pr-12" value="">
                                                        </div>
                                                    </div>
                                                    <div class="input-area">
                                                        Nhập số Xu muốn rút :
                                                        <div class="relative">
                                                            <input type="text" name="amount" id="sotien" oninput="num()" class="form-control !pr-12" value="">
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn inline-flex justify-center btn-dark">XÁC NHẬN</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-1 gap-6">
                                        <div class="card">
                                            <div class="card-body flex flex-col p-6">
                                                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                                                    <div class="flex-1">
                                                        <div class="card-title text-slate-900 dark:text-white">LỊCH SỬ RÚT TIỀN</div>
                                                    </div>
                                                </header>
                                                <div class="card-text h-full space-y-4">
                                                    <div class="card">
                                                        <div class="card-body px-6 pb-6">
                                                            <div class="overflow-x-auto -mx-6">
                                                                <div class="inline-block min-w-full align-middle">
                                                                    <div class="overflow-hidden ">
                                                                        <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                                                            <thead class="bg-slate-200 dark:bg-slate-700">
                                                                                <tr>
                                                                                    <th scope="col" class=" table-th " style="text-align: center;">
                                                                                        MGD
                                                                                    </th>

                                                                                    <th scope="col" class=" table-th " style="text-align: center;">
                                                                                        Số tiền
                                                                                    </th>
                                                                                    <th scope="col" class=" table-th " style="text-align: center;">
                                                                                        Thời gian
                                                                                    </th>
                                                                                    <th scope="col" class=" table-th " style="text-align: center;">
                                                                                        Trạng Thái
                                                                                    </th>

                                                                                </tr>
                                                                            </thead>
                                                                            <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                                                                <?php foreach ($history as $key => $historys) { ?>
                                                                                    <tr class="hover:bg-slate-200 dark:hover:bg-slate-700" style="text-align: center;">
                                                                                        <td class="table-td"><?= $historys["trans_id"] ?></td>
                                                                                        <td class="table-td"> <?= customNumberFormat($historys["money"]) ?></td>
                                                                                        <td class="table-td"> <?= $historys["time"] ?></td>
                                                                                        <td class="table-td"><?= statusPlayGame($historys["status"]) ?></td>
                                                                                    </tr>
                                                                                <?php  } ?>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    </daiv>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once(__DIR__ . "/layout/nav-mobile.php"); ?>
        </div>
    </main>
    <?php include_once(__DIR__ . "/layout/footer.php"); ?>
    <!-- <script src="/public/js/ajax.js"></script> -->
</body>
<script>
    function num() {
        var input = document.getElementById("sotien");
        var value = input.value;
        var numericValue = value.replace(/\D/g, "");
        var formattedValue = Number(numericValue).toLocaleString();
        input.value = formattedValue;
    }
</script>

</html>