<?php session_start();
include "../conf.php"; include "fungsi.php";
$notif_cl = '';
$fbid = $_SESSION['FBID'];
$query = mysqli_query($con,"select * FROM pengguna WHERE id_fb='$fbid'");
    while ($data=mysqli_fetch_assoc($query)){
		$nama_lengkap=$data['nama_dpn']." ".$data['nama_blk'];
		$username=$data['username'];
	}
  	$user=$username.".sukses.family";
//$nama_lengkap = $_SESSION['FULLNAME'];
$batas = 10;
$judul ='SuksesFamily'; $pencairan='';

$userByFbId = getUserByFbId($con,$fbid);

if(isset($_GET['h'])){
	$halaman = $_GET['h'];
}else{
	$halaman = 0;
}
$usr = cek($con,$db,$fbid);

//echo $usr;
$t_cair ='';
if($usr != 'no'){
	if(isset($_GET['t'])){
		$hala = $_GET['t'];
		if($hala == 'dp'){
			$dts = pembayaran($con,$db,$usr,$th1,$th2,$k_2th,$k_1th,$k_6bln);
			$data_pgg = $dts['tabel'];
			$cair = pencairan($con,$usr,$fbid);
			$pencairan = $cair['tabel_riwayat'];
			$judul = rp($dts['komisi']);
			if(date("d") == '13' OR date("d") == "14"){
				if($cair['norek'] == 'no'){
					if($dts['komisi'] >= 100000){
						$t_cair ='<a href="inisiasi.php" class="btn btn-danger btn-sm">Pencairan</a><small>tombol ini hanya muncul setiap tanggal 13 dan 14 </small>';
					}
				}
			}else{
				$t_cair='';
			}
		}
		if($hala == 'mt'){
			$dts = calon_mitra($con,$db,$usr,$halaman,$batas);
			$data_pgg = $dts;
			$judul = "Calon Mitra";
		}
		if($hala == 'kun'){
			$data_pgg = kunjungan($con,$db,$user);
			$judul = "Dashboard Kunjungan";
		}
	}else{
	$judul = 'Daftar Tagihan';
	$data_pgg = tagihan($con,$db,$usr,$halaman,$batas,$th1,$th2);
	}
}else{
	$judul ='';
	$data_pgg ='';
	header("Location: ganti_fb.php");
}

//jika ada yg claim mitra
if(isset($_POST['claim'])){


	//analisa formatnya
$mit = $_POST['claim'];
$frm = explode('.',$mit);
if(count($frm) == 3){
	if($frm[1] == 'sukses' and $frm[2]	== 'family'){
		//format benar
		$cl_user = $frm[0];
		$ada = mysqli_fetch_array(mysqli_query($con,"SELECT `tgl_lunas`,`referal` FROM `pengguna` WHERE `username`='$cl_user'"));
		if($ada){
			//ada

			if($ada['referal'] =='mandiri'){
			mysqli_query($con,"UPDATE `pengguna` SET `email` = NULL, `referal` = '$usr',`web_training`='tidak' WHERE `username` = '$cl_user'");

			$notif_cl = $notif_cl.'<div class="alert alert-success alert-with-icon" data-notify="container">
					<div class="container">
						<div class="alert-wrapper">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<i class="alert-icon fa fa-thumbs-up"></i>
							<div class="message"><b>Claim Berhasil! </b> Web Replika yang anda maksud sudah kami tambahkan ke /catatan ini refresh halaman ini dan cek di menu Home atau Komisi</div>
						</div>
					</div>
				</div>
				';
			}else{
				$notif_cl = $notif_cl.'<div class="alert alert-success alert-with-icon" data-notify="container">
					<div class="container">
						<div class="alert-wrapper">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<i class="alert-icon fa fa-lock"></i>
							<div class="message"><b>Claim Ditolak! </b> Web Replika yang anda maksud tidak mengalami gangguan sinyal/kendala teknis, replika tersebut mendaftar melalui replika lain (bukan replika anda). </div>
						</div>
					</div>
				</div>
				';
			}
		}else{
			//tdk ada
			$notif_cl = $notif_cl.'<div class="alert alert-info alert-with-icon" data-notify="container">
            <div class="container">
                <div class="alert-wrapper">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="alert-icon fa fa-eye-slash"></i>
                    <div class="message"><b>Web Replika Tidak Terdaftar! </b> Mungkin anda salah ketik, silahkan ulangi lagi</div>
                </div>
            </div>
        </div>
		';
		}

	}else{
		//format salah
		$notif_cl = $notif_cl.'
		<div class="alert alert-warning alert-with-icon" data-notify="container">
            <div class="container">
                <div class="alert-wrapper">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="alert-icon fa fa-bell"></i>
                    <div class="message"><b>Anda Salah Ketik! </b>ulangi sekali lagi, contoh : alamat web http://mitra.sukses.family maka masukan <b>mitra.sukses.family</b> dalam kotak "Claim Mitra" </div>
                </div>
            </div>
        </div>
		';
	}
}else{
	$notif_cl = $notif_cl.'
		<div class="alert alert-danger alert-with-icon" data-notify="container">
            <div class="container">
                <div class="alert-wrapper">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="alert-icon fa fa-exclamation-circle"></i>
                    <div class="message"><b>Format Salah! </b>contoh : alamat web http://mitra.sukses.family maka masukan <b>mitra.sukses.family</b> dalam kotak "Claim Mitra" </div>
                </div>
            </div>
        </div>
		';
}
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="../home/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Catatan Sukses Family</title>

	<!-- Canonical SEO -->
	<link rel="canonical" href="https://sukses.family/catatan"/>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link href="../bootstrap3/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/bootstrap-tour/css/bootstrap-tour.min.css" rel="stylesheet">
    <link href="../home/css/ct-paper.css" rel="stylesheet"/>
    <link href="../home/css/demo.css" rel="stylesheet" />
    <link href="../home/css/examples.css" rel="stylesheet" />
	<link href="../assets/css/style.css" rel="stylesheet">

	<script src="../bootstrap3/js/jquery.min.js"></script>
    <script src="../bootstrap3/js/bootstrap.min.js"></script>
    <script src="../assets/bootstrap-tour/js/bootstrap-tour.min.js"></script>


    <!--     Fonts and icons     -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-WV7W67N');</script>


</head>
<body class="search">
<?php echo $notif_cl; ?>
	<noscript>
		<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WV7W67N" height="0" width="0" style="display:none;visibility:hidden"></iframe>
	</noscript>
    <nav class="navbar navbar-relative navbar-ct-transparent navbar-burger" role="navigation-demo">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
            <span class="sr-only">Tombol</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo $judul.'</a>'.$t_cair; ?>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-white-collapse" id="navigation-example-2">
          <ul class="nav navbar-nav navbar-right">
                <li><a class="btn btn-simple btn-neutral">SuksesFamily</a></li>
                <li><a class="btn btn-simple btn-neutral"><?php echo date("Y") ?></a></li>
                <li><a href="https://twitter.com/" class="btn btn-simple btn-neutral"><i class="fa fa-twitter"></i> Twitter </a></li>
                <li><a href="https://www.facebook.com/" class="btn btn-simple btn-neutral"><i class="fa fa-facebook"></i> Facebook </a></li>
           </ul>

        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-->
    </nav>

    <div class="wrapper">
        <div class="main">
            <div class="section section-white section-search">
                <div class="container">
                    <?php echo $pencairan;?>
					<div class="row">
						<div class="col-md-6 col-xs-12 text-center" >
							<div class="row">
							<div class="info info-horizontal">
								<div class="icon">
									<!--<i class="fa fa-coffee"></i>-->
									<?php
									if(isset($_SESSION['FBID'])){
										echo '<img src="../uploads/poto/'.$_SESSION['FBID'].'.jpg"/>';
									}
									?>
								</div>
								<div class="description" id="panel1">
									<h4><?php echo $nama_lengkap;?> </h4>
									<p><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></p>
								</div>
							</div>
							</div>
                            <h6 class="text-muted">Followup Mitra</h6>
							<div class="progress">
							  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
								<span class="sr-only">Progress</span>
							  </div>
							</div>
                            <ul class="list-unstyled follows">
								<?php echo $data_pgg;?>
                            </ul>
                            <div class="text-missing">
                                <h5 class="text-muted">Mari pantau gerakan digital marketing downline kita melalui facebook. Berteman dengan mereka dengan klik tombol facebook </h5>
                            </div>
                        </div>
						<div class="col-md-6 col-xs-12 text-center">

						</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <footer class="footer-demo section-white-gray">
        <div class="container">

            <nav class="pull-left col-md-10">
                <ul>
					<li> </li>
                    <li class="col-lg-1 col-xs-12 text-center" id="panel2">

                        <a href="?t=dp">
                            Komisi
                        </a>

                    </li>
                    <li class="col-lg-1 col-xs-12 text-center" id="panel3">

                        <a href="?t=mt">
                           CaMit
                        </a>

                    </li>
                    <li class="col-lg-1 col-xs-12 text-center" id="panel4">

                        <a href="?b=">
                            Home
                        </a>

                    </li>
					<li class="col-lg-1 col-xs-12 text-center" id="panel5">

						<a href="../daftar/pembayaran.php">
							Upgrade
						</a>

					</li>
					<li class="col-lg-1 col-xs-12 text-center" id="panel6">

						 <a href="?t=kun">
							Kunjungan
						</a>

					</li>
					<li class="col-lg-1 col-xs-12 text-center" id="panel7">

						 <a href="canvas.php">
							FrameFoto
						</a>

					</li>
                </ul>
            </nav>

            <div class="copyright pull-right">
                <b>&copy; DTS Jakarta</b>
            </div>
        </div>
    </footer>

    <script>
      // Instance the tour
      var tour = new Tour({
        // name:'sukses family',
        backdrop:true,
        steps: [{
          element: "#panel1",
          title: "Nama Anda",
          content: "Merupakan nama yang anda gunakan"
        },{
          element: "#panel2",
          title: "Menu Komisi",
          content: "Untuk mengetahui jumlah komisi atau bonus yang anda dapatkan"
        },{
          element: "#panel3",
          title: "Menu CaMit(Calon mitra)",
          content: "Untuk melihat list calon mitra yang ingin bergabung"
        },{
          element: "#panel4",
          title: "Menu Home",
          content: "kembali ke beranda/home"
        },{
          element: "#panel5",
          title: "Menu Upgrade",
          content: "upgrade web replika untuk memperpanjang masa aktif"
        },{
          element: "#panel6",
          title: "Menu Kunjungan",
          content: "untuk melihat total pengunjung web anda"
        },{
          element: "#panel7",
          title: "Menu FrameFoto",
          content: "Menambahkan frame pada foto profil anda"
        }]
      });

      // Initialize the tour
      tour.init();

      // Start the tour
      tour.start();
    </script>

</body>

<script src="../home/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="../home/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>

<script src="../bootstrap3/js/bootstrap.js" type="text/javascript"></script>

<!--  Plugins -->
<script src="../home/js/ct-paper-checkbox.js"></script>
<script src="../home/js/ct-paper-radio.js"></script>
<script src="../home/js/ct-paper-bootstrapswitch.js"></script>

<!--  for fileupload -->
<script src="../home/js/jasny-bootstrap.min.js"></script>

<script src="../home/js/ct-paper.js"></script>
</html>
