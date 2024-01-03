 <!-- BEGIN: Sidebar -->
 <!-- BEGIN: Sidebar -->


 <div class="sidebar-wrapper group">
   <div id="bodyOverlay" class="w-screen h-screen fixed top-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm z-10 hidden"></div>
   <div style="background-color: #99CCFF;"  class="logo-segment">
     <a class="flex items-center" href="">
      <img src="/views/images/logo001.gif" class="black_logo" style="width: 20px;" alt="logo">
       <img src="/views/images/logo001.gif" class="white_logo" style="width: 30px;" alt="logo">
       <span class="ltr:ml-3 rtl:mr-3 text-xl font-Inter font-bold text-slate-900 dark:text-white" style="color: white;"><?php echo $_ENV['APP_NAME']; ?> </span>
     </a>

     <button class="sidebarCloseIcon text-2xl">
       <!-- <iconify-icon class="text-slate-900 dark:text-slate-200" icon="clarity:window-close-line"></iconify-icon> -->
       <iconify-icon class="text-slate-900 dark:text-slate-200" icon="ri-arrow-left-circle-line"></iconify-icon>
     </button>
   </div>

   
   <div id="nav_shadow" class="nav_shadow h-[60px] absolute top-[80px] nav-shadow z-[1] w-full transition-all duration-200 pointer-events-none
      opacity-0"></div>
   <div style="background-color: #99CCFF;" class="sidebar-menus bg-white dark:bg-slate-800 py-2 px-4 h-[calc(100%-80px)] overflow-y-auto z-50" id="sidebar_menus">
     <ul class="sidebar-menu">
       <li class="sidebar-menu-title"></li>
       <li class="">
         <a href="/" class="navItem">
           <span class="flex items-center">
             <iconify-icon class=" nav-icon"  icon="uiw:home"></iconify-icon>
           <span style="color: white; font-size: 15px;">Trang Chủ</span>
           </span>
         </a>
       </li>
       <li>
         <a href="/profile" class="navItem">
           <span class="flex items-center">
           <iconify-icon class=" nav-icon" icon="ri:admin-line"></iconify-icon>
           <span style="color: white; font-size: 15px;">Thông Tin Tài khoản</span>
           </span>
         </a>
       </li>
       <li class="">
         <a href="/withdraw" class="navItem">
           <span class="flex items-center">
             <iconify-icon class=" nav-icon" icon="tabler:pig-money"></iconify-icon>
           <span style="color: white; font-size: 15px;">Rút Xu</span>
           </span>
         </a>
       </li>
       <li class="">
         <a href="/recharge" class="navItem">
           <span class="flex items-center">
             <iconify-icon class=" nav-icon" icon="solar:hand-money-broken"></iconify-icon>
           <span style="color: white; font-size: 15px;">Nạp Xu</span>
           </span>
         </a>
       </li>
       <br><br>

       <li class="">
        <a href="<?php echo $_ENV['chatadmin']; ?>" class="navItem">
           <span class="flex items-center">
           <iconify-icon class=" nav-icon" icon="healthicons:security-worker-outline"></iconify-icon>
            <span style="color: white; font-size: 15px;">Admin Hỗ Trợ</span>
           </span>
         </a>
       </li>
       <li class="">
         <a href="/cach-choi" target="_blank" class="navItem">
           <span class="flex items-center">
             <iconify-icon class=" nav-icon" icon="heroicons-outline:clipboard-check"></iconify-icon>
           <span style="color: white; font-size: 15px;">Cách Chơi</span>
           </span>
         </a>
       </li>
       <li class="">
         <a href="/logout" class="navItem">
           <span class="flex items-center">
           <iconify-icon class=" nav-icon" icon="mdi:robot-dead-outline"></iconify-icon>
          <span style="color: white; font-size: 15px;">Đăng Xuất</span>
           </span>
         </a>
       </li>
   </div>
 </div>
<style>
.semiDark .logo-segment,
.semiDark .sidebar-menus,
.semiDark .sidebar-wrapper {
  --tw-bg-opacity: 1;
  background-color: #99CCFF; /* Thay đổi màu thành #99CCFF */
}

.navItem .nav-icon {
    font-size: 25px;
    color: #00FFFF;
}
</style>
 <!-- End: Sidebar -->
 <!-- End: Sidebar -->