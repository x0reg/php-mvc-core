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
                                                    <div class="card-title text-slate-900 dark:text-white">Thông Tin Tài Khoản</div>
                                                </div>
                                            </header>
                                            <div class="card-text h-full space-y-4">
                                                <div class="input-area">
                                                    Tài Khoản :
                                                    <div class="relative">
                                                        <input type="text" class="form-control !pr-12" value="<?= $info["username"] ?>" disabled="disabled">

                                                    </div>
                                                </div>

                                                <div class="input-area">
                                                    Số Dư :
                                                    <div class="relative">
                                                        <input type="text" class="form-control !pr-12" value="<?= customNumberFormat($info["money"]) ?>" disabled="disabled">

                                                    </div>
                                                </div>

                                                <div class="input-area">
                                                    Thời Gian Tham Gia :
                                                    <div class="relative">
                                                        <input type="text" class="form-control !pr-12" value=" <?= $info["time"] ?>" disabled="disabled">

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-1 gap-6">
                                        <div class="card">
                                            <div class="card-body flex flex-col p-6">
                                                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                                                    <div class="flex-1">
                                                        <div class="card-title text-slate-900 dark:text-white">Đổi Mật Khẩu</div>
                                                    </div>
                                                </header>
                                                <form action="/api/change-password" method="POST" id="ajaxSubmitForm">
                                                    <div class="card-text h-full space-y-4">
                                                        <div class="input-area">
                                                            <label for="defaultInput" class="mb-2 block cursor-pointer font-Inter font-medium capitalize text-slate-700 dark:text-slate-50 leading-6">Mật khẩu hiện tại</label>
                                                            <div class="relative">
                                                                <input type="text" name="password" id="password" class="form-control !pl-12" placeholder="Mật khẩu hiện tại">
                                                                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-9 h-full text-xl border-r border-r-slate-200 dark:border-r-slate-700 flex items-center justify-center">
                                                                    <iconify-icon icon="bi:fingerprint"></iconify-icon>

                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="input-area">
                                                            <label for="defaultInput" class="mb-2 block cursor-pointer font-Inter font-medium capitalize text-slate-700 dark:text-slate-50 leading-6">Mật Khẩu Mới</label>
                                                            <div class="relative">
                                                                <input type="text" id="new_passwd" name="new_passwd" class="form-control !pl-12" placeholder="Mật khẩu mới">
                                                                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-9 h-full text-xl border-r border-r-slate-200 dark:border-r-slate-700 flex items-center justify-center">
                                                                    <iconify-icon icon="bi:fingerprint"></iconify-icon>

                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="input-area">
                                                            <label for="defaultInput" class="mb-2 block cursor-pointer font-Inter font-medium capitalize text-slate-700 dark:text-slate-50 leading-6">Nhập Lại Mật Khẩu Mới</label>
                                                            <div class="relative">
                                                                <input type="text" id="re_newpasswd" name="re_newpasswd" class="form-control !pl-12" placeholder="Nhập Lại Mật khẩu mới">
                                                                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-9 h-full text-xl border-r border-r-slate-200 dark:border-r-slate-700 flex items-center justify-center">
                                                                    <iconify-icon icon="bi:fingerprint"></iconify-icon>

                                                                </span>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn inline-flex justify-center btn-dark">Cập Nhật</button>
                                                    </div>
                                                </form>
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
</body>
<script>

</script>

</html>