<!DOCTYPE html>
<html lang="en" dir="ltr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title></title>
    <link rel="icon" type="image/png" href="public/images/logo/images.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/rt-plugins.css">
    <link href="https://unpkg.com/aos@2.3.0/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="">
    <link rel="stylesheet" href="/public/css/app.css">
    <!-- START : Theme Config js-->
    <script src="/public/js/settings.js" sync></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- END : Theme Config js-->
</head>
<style>
    .error {
        color: red;
    }
</style>

<body class=" font-inter dashcode-app" id="body_class">
    <!-- [if IE]> <p class="browserupgrade">
            You are using an <strong>outdated</strong> browser. Please
            <a href="https://browsehappy.com/">upgrade your browser</a> to improve
            your experience and security.
        </p> <![endif] -->

    <div class="loginwrapper">
        <div class="lg-inner-column">
            <div class="left-column relative z-[1]">
                <div class="max-w-[520px] pt-20 ltr:pl-20 rtl:pr-20">

                    <h4>
                        
                        <!-- <span class="text-slate-800 dark:text-slate-400 font-bold">
							performance
						</span> -->
                    </h4>
                </div>
                <div class="absolute left-0 2xl:bottom-[-160px] bottom-[-130px] h-full w-full z-[-1]">
                    <img src="/public/images/auth/ils1.svg" alt="" class=" h-full w-full object-contain">
                </div>
            </div>
            <div class="right-column  relative">
                <div class="inner-content h-full flex flex-col bg-white dark:bg-slate-800">
                    <div class="auth-box h-full flex flex-col justify-center">
                        <div class="mobile-logo text-center mb-6 lg:hidden block">
                            <a href="/">
                                <img src="<?=Settings("logo") ?>" alt="" style="margin-left: 12px";  class="mb-10 dark_logo">
                                <img src="<?=Settings("logo") ?>" alt="" class="mb-10 white_logo">
                            </a>
                        </div>
                        <div class="text-center 2xl:mb-10 mb-4">
                            <h4 class="font-medium">Đăng Nhập Ngay</h4>
                            <div class="text-slate-500 text-base">
                                Sử dụng tài khoản Vuabem.com để đăng nhập
                            </div>
                        </div>
                        <!-- BEGIN: Login Form -->

                        <form class="space-y-4" action='/api/login' method="POST" id="ajaxSubmitForm">
                            <div class="fromGroup">
                                <label class="block capitalize form-label">Tài Khoản</label>
                                <div class="relative ">
                                    <input id="username" type="text" name="username" class="form-control" onfocus="clearError('nameError')" placeholder="Username">
                                </div>
                                <b id="nameError"></b>
                            </div>
                            <div class="fromGroup       ">
                                <label class="block capitalize form-label  ">Mật khẩu</label>
                                <div class="relative ">
                                    <input id="password" type="password" name="password" onfocus="clearError('passwordError')" class="form-control pr-9" placeholder="Password">
                                    <button id="passIcon" class="passIcon absolute top-2.5 right-3 text-slate-300 text-xl p-0 leading-none" type="button">
                                        <iconify-icon id="passwordIcon" class="inline-block" icon="heroicons-solid:eye-off"></iconify-icon>
                                    </button>

                                </div>
                                <b id="passwordError"></b>
                            </div>

							<style>
  @keyframes blink {
    0% {opacity: 1;}
    50% {opacity: 0.5;}
    100% {opacity: 1;}
  }
  .mb {
    font-size: 15px;
    text-align: right;
    color: #00f;
}

							</style>
							
                            <button type="submit" style="animation: blink 1s ease infinite;"class="btn btn-light w-full text-center">Đăng Nhập Ngay</button>
                        </form>
						<p style="height: 10px;"></p>
						<a class="mb" href="<?php echo $_ENV['chatadmin']; ?>" ><b>Quên mật khẩu?</b></a>	
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="/public/js/jquery-3.6.0.min.js"></script>
    <script src="/public/js/rt-plugins.js"></script>
    <script src="/public/js/app.js"></script>
    <script src="/public/js/ajax.js"></script>
</body>

<script>
    document.getElementById('passIcon').addEventListener('click', function() {
        var passwordInput = document.getElementById('password');
        var passwordIcon = document.getElementById('passwordIcon');

        // Toggle password visibility
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.setAttribute('icon', 'heroicons-solid:eye');
        } else {
            passwordInput.type = 'password';
            passwordIcon.setAttribute('icon', 'heroicons-solid:eye-off');
        }
    });
</script>
<script>
    function validateForm() {
        // Reset errors
        document.getElementById('nameError').textContent = '';
        document.getElementById('passwordError').textContent = '';
        var name = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        if (name.trim() === '' && password.trim() === '') {
            document.getElementById('passwordError').innerHTML = '<b class="error">Vui lòng Nhập mật khẩu</b>';
            document.getElementById('nameError').innerHTML = '<b class="error">Vui lòng nhập vào trường tài khoản</b>';
            return false;
        }
        // Validate name

        if (name.trim() === '') {
            document.getElementById('nameError').innerHTML = '<b class="error">Vui lòng nhập vào trường tài khoản</b>';
            return false;
        }

        // Validate password

        if (password.trim() === '') {
            document.getElementById('passwordError').innerHTML = '<b class="error">Vui lòng Nhập mật khẩu</b>';
            return false;
        }


    }

    function clearError(errorId) {
        // Clear error message when input field is focused
        document.getElementById(errorId).textContent = '';
    }
</script>


</html>