<p class="text-danger h6">Số Dư Thực :<b id="soduthuc"> <?= customNumberFormat(getInfoUser("money")) ?></b> xu</p> 
<br>
<div class="input-area">
    <label class="block font-medium text-secondary-700 dark:text-secondary-400">Đặt
        Xu Cược:</label>
    <input id="amount" value="" type="text" class="form-control mt-1" placeholder="1.000 - 500.000 xu">
</div>

<div class="card mt-3">
    <div class="card-text h-full ">
        <div class="btn-group-example btn-group">
            <button class="addAmount btn inline-flex justify-center btn-primary btn-sm" data-amount="10000">
                <span class="flex items-center">
                    <span>+10</span>
                </span>
            </button>
            <button class="addAmount btn inline-flex justify-center btn-primary btn-sm" data-amount="50000">
                <span class="flex items-center">
                    <span>+50</span>
                </span>
            </button>
            <button class="addAmount btn inline-flex justify-center btn-primary btn-sm" data-amount="100000">
                <span class="flex items-center">
                    <span>+100</span>
                </span>
            </button>
            <button class="addAmount btn inline-flex justify-center btn-primary btn-sm" data-amount="200000">
                <span class="flex items-center">
                    <span>+200</span>
                </span>
            </button>
            <button class="addAmount btn inline-flex justify-center btn-primary btn-sm" data-amount="500000">
                <span class="flex items-center">
                    <span>+500</span>
                </span>
            </button>
            <button id="clearButton" class="btn inline-flex justify-center btn-danger btn-sm">
                <span class="flex items-center">
                    <span>Xóa</span>
                </span>
            </button>
        </div>
    </div>
</div>