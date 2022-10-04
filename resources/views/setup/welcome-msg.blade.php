
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <?php
            // I'm India so my timezone is Asia/Calcutta
            date_default_timezone_set('Asia/Calcutta');

            // 24-hour format of an hour without leading zeros (0 through 23)
            $Hour = date('G');

            if ( $Hour >= 5 && $Hour <= 11 ) {
                $msg= "Good Morning";
            } else if ( $Hour >= 12 && $Hour <= 18 ) {
                $msg= "Good Afternoon";
            } else if ( $Hour >= 19 || $Hour <= 4 ) {
                $msg= "Good Evening";
            }
            ?>
            <h4 class="page-title">{{$msg}}  </h4>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">{{\Illuminate\Support\Facades\Auth::user()->name}}</li>
            </ul>
        </div>
    </div>
</div>
