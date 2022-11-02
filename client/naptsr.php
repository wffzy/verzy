<?php include '../config/head.php'; ?>
<title>NẠP THESIEURE AUTO</title>
<?php include '../config/nav.php'; ?>
<?php
if($bentancoder['status_naptsr'] == 'OFF')
{
   die('<script> if (confirm("Chức năng này đã bị admin tắt !")) {
    window.location="/";
} else {
    alert("Đã huỷ");
    window.location="?ok";
}
  </script>');
}
?>


<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Nạp Qua Thesieure</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Nạp Tiền</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Thesieure</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
     <!-- Default Basic Forms Start -->
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="text-blue h4">NẠP TIỀN BẰNG THESIEURE</h4>
                        <p class="mb-30">Nạp tiền qua ví thesieure tự động<br>
                    </div>
                    <div class="pull-right">
                        <a href="#" class="btn btn-primary btn-sm scroll-click" rel="content-y" data-toggle="collapse"
                            role="button">Auto</a>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Số tài khoản:</label>
                    <div class="col-sm-12 col-md-10">
                        <b class="text-danger"
                            style="border: 2px dashed #e04f1a30; padding: 3px; color: #e53e3e!important;" id="copySDT">dichvuwhm</b> <a class="copy"
                            data-clipboard-target="#copySDT"><i class="fa fa-copy"></i></a>
                    </div>
                </div>
                <?php if($_SESSION['username']) { ?>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Nội dung chuyển tiền:</label>
                    <div class="col-sm-12 col-md-10">
                        <b class="text-danger"
                            style="border: 2px dashed #e04f1a30; padding: 3px; color: #e53e3e!important;"
                            id="copyNoiDung"><?=$user['id'];?></b>
                        <a class="copy" data-clipboard-target="#copyNoiDung"><i class="fa fa-copy"></i></a>
                    </div>
                </div>
                <?php } ?>
                <?php if(!$_SESSION['username']) { ?>
                <div class="form-group row">
                    <label class="col-sm-12 col-md-2 col-form-label">Nội dung chuyển tiền:</label>
                    <div class="col-sm-12 col-md-10">
                        <b class="text-danger"
                            style="border: 2px dashed #e04f1a30; padding: 3px; color: #e53e3e!important;"
                            id="copyNoiDung">Vui lòng đăng nhập</b>
                        <a class="copy" data-clipboard-target="#copyNoiDung"><i class="fa fa-copy"></i></a>
                    </div>
                </div>
                <?php } ?>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">Nhập mã giao dịch:</label>
                        <div class="col-sm-12 col-md-10">
                            <input class="form-control" type="text" name="magd" placeholder="Nhập mã giao dịch ...">
                        </div>
                    </div>
                    
                    
                        <button class="btn btn-primary" id="bentancoder" type="submit"><i class="fa fa-send mr-1"></i> Nạp Ngay</button>
                    </div>
            </div>
           <!-- Export Datatable start -->
             <div class="card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">LỊCH SỬ NẠP THESIEURE</h4>
                    
                </div>
                <div class="pd-20 card-box height-100-p">
                    <table class="table hover multiple-select-row data-table-export nowrap">
                        <thead>
                            <tr>
                                <th class="table-plus datatable-nosort">STT</th>
                                <th>MÃ GD</th>
                                <th>THỰC NHẬN</th>
                                <th>THỜI GIAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$i = 1;
$cash = mysqli_query($ketnoi, "SELECT * FROM bentancoder_naptsr where `uid` = '".$user['id']."'");
if($user['level'] == '810'){
    $cash = mysqli_query($ketnoi, "SELECT * FROM bentancoder_naptsr where `seri` = 'Nạp từ thesieure'");
}
if (mysqli_num_rows($cash) == 0):
?><tr><td colspan="7" class="text-center">Chưa có lượt nạp nào!</td></tr>
<?php else: while ($row = mysqli_fetch_array($cash, MYSQLI_ASSOC)):?>
                            <tr>
                                <td><?=$i;?> <?php $i++;?></td>
                                <td><?=$row['code'];?></td>
                                <td><?=number_format($row['sotien']);?>đ</td>
                                <td><span class="badge badge-dark"><?=date("H:i:s - d/m/Y", $row['time']);?></span></td>
                            </tr>
                            <?php endwhile; endif; ?> 
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- Export Datatable End -->
   <script>
// ajax
 	$(document).ready(function(){
		$('#bentancoder').click(function() {
		$('#bentancoder').html('Đang kiểm tra...');
		$('#bentancoder').prop('disabled', true);
		var formData = {
		'thaotac' : '1',
        'magd'              : $('input[name=magd]').val()
		};
		$.post("/naptsrajax", formData,
		function (data) {
			    if(data.status == '1'){
			swal({
					title : "Thông báo",
					html: data.msg, 
					buttonsStyling: false,
                    confirmButtonClass: "btn btn-primary",
					type: data.type
				});
				$('#bentancoder').html('<i class="fa fa-send mr-1"></i> Nạp Ngay');
			$('#bentancoder').prop('disabled', false);
			    }else{
			    // window.location="/";   
			    swal({
					title : "Thông báo",
					html: data.msg, 
					buttonsStyling: false,
                    confirmButtonClass: "btn btn-primary",
					type: data.type
				});
				$('#bentancoder').html('<i class="fa fa-send mr-1"></i> Nạp Ngay');
			$('#bentancoder').prop('disabled', false);
			    }
		}, "json");
	});
});

</script>

<?php include '../config/foot.php'; ?>