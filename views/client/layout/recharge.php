<div class="row align-items-md-stretch">
    <div class="col-md-6">
        <div class="h-100 p-1 bg-light border rounded-3">
            <div class="text-center">
                <h5> QUÉT MÃ QR </h5>
                <center>
                    <img src="<?= $qr ?>" width="200">
                </center>
            </div>
            <br>
            <center>
                <a class="btn btn-success" href="momo://?action=p2p&extra={%22dataExtract%22:%22<?= $payloadMomo ?>%22}" >MỞ
                   ỨNG DỤNG MOMO NHANH <i class="fas fa-external-link-alt"></i></a>
           </center>
           <br>
       </div>
   </div>
</div>
<div class="py-[18px] px-6 font-normal rounded-md bg-white text-primary-500 border border-primary-500
                                    dark:bg-slate-800">
                                    <center>
                                   <h5 class"text-center">THÔNG TIN THANH TOÁN</h5>
                                   </center>
                                   <hr>
                            <div class="flex items-start space-x-3 rtl:space-x-reverse">
                              <div class="flex-1 font-Inter">
                                Số Tài Khoản : <span style="color:red"><?= $getPhoneMM["stk"] ?></span><br>
                                Chủ Tài Khoản : <span style="color:red"><?= $getPhoneMM["ctk"] ?></span><br>
                                Số Tiền  : <span style="color:red"><?= number_format($sotien) ?></span>
                              </div>
                            </div>
                          </div>