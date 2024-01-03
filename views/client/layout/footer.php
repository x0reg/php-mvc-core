<!-- scripts -->
<script src="/public/js/jquery-3.6.0.min.js"></script>
<script src="/public/js/rt-plugins.js"></script>
<script src="/public/js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="public/js/devtool.js"></script> -->
<script src="/public/js/ajax.js"></script>
<!--<script src="/public/js/DTT.js"></script>-->
<!--<script src="/public/js/DT.js"></script>-->
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js"></script>
<script>
    var clipboard = new ClipboardJS('.copyText');

    clipboard.on('success', function(e) {
        alert("Copy Thành Công " + e.text)
        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
    });
</script>

 <script>
    DisableDevtool({
        alert: true,
        check: true,
        checkTimer: 1000,
        alertMessage: "Developer tools detected!"
    });
</script>


<script>
    // Chặn tất cả phím tắt mở DevTools
    // document.onkeydown = function(e) {
    //     if (
    //         (e.ctrlKey && e.shiftKey && e.keyCode == 73) || // Chặn Ctrl+Shift+I
    //         (e.ctrlKey && e.shiftKey && e.keyCode == 74) || // Chặn Ctrl+Shift+J
    //         (e.keyCode == 123) // Chặn F12
    //     ) {
    //         return false;
    //     }
    // };
    // Chặn chuột phải để ngăn xem mã nguồn
    // document.addEventListener("contextmenu", function(e) {
    //     e.preventDefault();
    //     return false;
    // });
</script>