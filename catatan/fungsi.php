<?php
require_once __DIR__ . '/vendor/autoload.php';
//VALIDASI
function cek($con,$db,$idfb){

	$lunas = TRUE; $blm_exp = TRUE;
	$qu = mysqli_query($con,"select username,tgl_exp,web_training,marketing,tgl_lunas,id_fb,nama_dpn,nama_blk from pengguna WHERE id_fb ='$idfb'");
	$data = mysqli_fetch_array($qu);
		if(isset($data['username'])){

			if(is_null($data['tgl_lunas'])){
				$lunas = FALSE;
			}
			$skr = strtotime("today");
			$exp = strtotime($data['tgl_exp']);
			if($skr >= $exp){
				$blm_exp = FALSE;
			}
			if($data['id_fb'] AND $lunas AND $blm_exp){
				$usr = $data['username'];
			}else{
				$usr ='no';
			}
		}else{
			$usr = 'no';
		}
		return $usr;
}
	function status($pay,$tglunas,$sewa){
		//BUY paket bisnis
		if(is_null($pay)){
			//jika blm lunas
			if(is_null($tglunas)){
			$stat = "Bisnis Tunggu Transfer";
			}else{
			$stat ="Daftar Paytren";
			}
		}else{
			if(is_null($tglunas)){
			$stat =$sewa."Replika Tunggu Transfer";
			}else{
			$stat =$sewa."Replika Aktif";
			}
		}
		return $stat;
	}
//LIHAT TAGIHAN REPLIKA
function tagihan($con,$db,$usr,$halaman,$batas,$th1,$th2){
	$q= "SELECT `username`,`no_wa`,`tgl_exp`,`id_fb`,`nama_fb`,`nama_dpn`,`paytren_id`,`nominal`,`tgl_lunas` FROM `$db`.`pengguna`  WHERE `referal` = '$usr' AND `tgl_lunas` IS NULL LIMIT $halaman,$batas";
	$quq = mysqli_query($con,$q);
	$jmldata    = mysqli_num_rows($quq);
	$jmlhalaman = ceil($jmldata/$batas);
	$hsl =''; $tabelh='';
	while($pgg = mysqli_fetch_array($quq)){
		$angg = $pgg['nominal'];
		if($angg + 40000 >= $th2){
			$sewa ='2th ';
		}else if($angg + 40000 >= $th1){
			$sewa ='1th ';
		}else{
			$sewa ='6bln ';
		}
		$hsl = $hsl.'
								<li>
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1 col-xs-5 col-xs-offset-1">
                                            <img src="../poto/'.$pgg['id_fb'].'.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                        </div>
                                        <div class="col-md-6 col-xs-4 description">
                                            <h5>'.$pgg['nama_fb'].'<br /><small>'.status($pgg['paytren_id'],$pgg['tgl_lunas'],$sewa).'</small></h5>
                                        </div>
                                        <div class="col-md-2 col-xs-2">
                                            <a class="btn btn-icon btn-danger" href="https://api.whatsapp.com/send?phone='.ke_wa($pgg['no_wa']).'&text=Hallo%20'.$pgg['nama_dpn'].'%2C%20"><i class="fa fa-phone-square"></i></a>
											<a class="btn btn-icon btn-info" href="https://www.facebook.com/'.$pgg['id_fb'].'"><i class="fa fa-facebook"></i></a>
                                        </div>
                                    </div>
                                </li>
			';
	}
	for($i=1;$i<=$jmlhalaman;$i++){
		if ($i != $halaman){
		 $a = '<li><a href="./anti.php?h='.$i.'">'.$i.'</a></li>';

		}
		else{
		 $a = '<li class="active"><a>'.$i.'</a></li>';
		}
		$tabelh=$tabelh.$a;
	}
	$q_u = mysqli_query($con,"SELECT `idfb`,`username`,`nominal_up`,`upgrade`,`bagi_hasil` FROM `upgrade` WHERE `referal` ='$usr' AND `tgl_lunas` IS NULL ");
	while($up = mysqli_fetch_array($q_u)){
		$hsl = $hsl.'
			<li>
				<div class="row">
					<div class="col-md-2 col-md-offset-1 col-xs-5 col-xs-offset-1">
						<img src="../poto/'.$up['idfb'].'.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive"/>
					</div>
					<div class="col-md-6 col-xs-4 description">
						<h5>'.$up['username'].'.sukses.family <br/><small>Upgrade Replika '.$up['upgrade'].' bulan</small></h5>
					</div>
					<div class="col-md-2 col-xs-2">
						<a class="btn btn-icon btn-info" href="https://www.facebook.com/'.$up['idfb'].'"><i class="fa fa-facebook"></i></a>
					</div>
				</div>
			</li>';
	}
	$halm = '<ul class="pagination pagination-danger">'.$tabelh.'</ul>';
	return $hsl.$halm;
	//return $q;
}
/*
function kunjungan($con,$db,$user){
	$Qry2 = mysqli_query($con,"select count(nominal) from pengguna where date(tgl_lunas)=date(now())");
	$data2 = mysqli_fetch_row($Qry2);
	$hsl = $hsl.'
		<div class="row">
			<div class="col-lg-12 col-xs-12">
				<div class="small-box" style="background-color:#af9c8b; color:#FFFFFF">
					<div class="inner" style="text-align:center">
						<h3>'.$data2[0].'<sup style="font-size: 18px"> Orang</sup></h3>
					</div>
					<div class="small-box-footer">
					  Jumlah Kunjungan Hari ini
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-xs-12">
				<div class="small-box" style="background-color:#af9c8b; color:#FFFFFF">
					<div class="inner" style="text-align:center">
						<h3>'.$data2[0].'<sup style="font-size: 18px"> Orang</sup></h3>
					</div>
					<div class="small-box-footer">
					  Jumlah Kunjungan Bulan ini
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-xs-12">
				<div class="small-box" style="background-color:#af9c8b; color:#FFFFFF">
					<div class="inner" style="text-align:center">
						<h3>'.$data2[0].'<sup style="font-size: 18px"> Orang</sup></h3>
					</div>
					<div class="small-box-footer">
					  Jumlah Total Kunjungan
					</div>
				</div>
			</div>
		</div>';
	return $hsl;
}
*/
function pembayaran($con,$db,$usr,$th1,$th2,$k_2th,$k_1th,$k_6bln){
	$q= "SELECT `username`,`no_wa`,`tgl_exp`,`id_fb`,`nama_fb`,`nama_dpn`,`paytren_id`,`nominal`,`tgl_lunas`
		FROM `$db`.`pengguna`
		WHERE `referal` = '$usr' AND `tgl_lunas` IS NOT NULL AND `web_training` ='tidak' ";
	$quq = mysqli_query($con,$q);
	$hsl =''; $tabelh=''; $komisi_n =0;

	while($pgg = mysqli_fetch_array($quq)){
		$angg = $pgg['nominal'];
		if($angg + 40000 >= $th2){
			$sewa ='2th ';
			$komisi = $k_2th;
		}else if($angg + 40000 >= $th1){
			$sewa ='1th ';
			$komisi = $k_1th;
		}else{
			$sewa ='6bln ';
			$komisi = $k_6bln;
		}
		$komisi_n = $komisi_n+$komisi;
		$rp_nom = $komisi/1000;
		$hsl = $hsl.'
								<li>
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1 col-xs-5 col-xs-offset-1">
										<span class="label label-success notification-bubble"> '.$rp_nom.'K </span>
                                            <img src="../poto/'.$pgg['id_fb'].'.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive"/>
                                        </div>
                                        <div class="col-md-6 col-xs-4 description">
                                            <h5>'.$pgg['nama_fb'].'<br /><small>'.status($pgg['paytren_id'],$pgg['tgl_lunas'],$sewa).'</small></h5>
                                        </div>
                                        <div class="col-md-2 col-xs-2">
                                            <a class="btn btn-icon btn-danger" href="https://api.whatsapp.com/send?phone='.ke_wa($pgg['no_wa']).'&text=Hallo%20'.$pgg['nama_dpn'].'%2C%20"><i class="fa fa-phone-square"></i></a>
											<a class="btn btn-icon btn-info" href="https://www.facebook.com/'.$pgg['id_fb'].'"><i class="fa fa-facebook"></i></a>
                                        </div>
                                    </div>
                                </li>
			';
	}
	$q_u = mysqli_query($con,"SELECT `tgl_lunas`,`idfb`,`username`,`nominal_up`,`upgrade`,`bagi_hasil`,`basil_dibayar`
			FROM `upgrade`
			WHERE (`referal` ='$usr' AND `tgl_lunas` IS NOT NULL AND `basil_dibayar` = 'audit')
				OR (`referal` ='$usr' AND `tgl_lunas` IS NOT NULL AND `basil_dibayar` is null)");
	while($up = mysqli_fetch_array($q_u)){
		$k_up = $up['bagi_hasil'];
		$denom_k = $k_up/1000;
		$komisi_n = $komisi_n + $k_up;
		$hsl = $hsl.'
								<li>
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1 col-xs-5 col-xs-offset-1">
										<span class="label label-success notification-bubble"> '.$denom_k.'K </span>
                                            <img src="../poto/'.$up['idfb'].'.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive"/>
                                        </div>
                                        <div class="col-md-6 col-xs-4 description">
                                            <h5>'.$up['username'].'.sukses.family <br/><small>Upgrade Replika '.$up['upgrade'].' bulan</small></h5>
                                        </div>
                                        <div class="col-md-2 col-xs-2">

											<a class="btn btn-icon btn-info" href="https://www.facebook.com/'.$up['idfb'].'"><i class="fa fa-facebook"></i></a>
                                        </div>
                                    </div>
                                </li>
			';
	}

	$hsl =$hsl.'
			<form role="search" class="form-inline" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control border-input" placeholder="Claim Mitra" name="claim">
                </div>
                <button type="submit" class="btn btn-icon btn-fill"><i class="fa fa-search"></i></button>
				<p><small>Terkadang karena sinyal yang kurang stabil menyebabkan mitra yang mendaftar replika lewat kita tidak tercatat, anda bisa claim mitra tersebut dengan memasukan alamat replika mitra tanpa "http://" </small></p>
            </form>
			';
	return array('tabel' => $hsl, 'komisi' => $komisi_n);
}
function calon_mitra($con,$db,$usr,$halaman,$batas){
	$hll = $halaman * $batas;
	$q= "select nama,nope,tgl_daftar from $db.pendaftar where asal='$usr' AND nope !='' GROUP BY nope` LIMIT $hll,$batas";
	$qu = mysqli_query($con,$q); $hsl ='';$tabelh='';
	$jmldata    = mysqli_num_rows($qu);
	$jmlhalaman = ceil($jmldata/$batas);
	while($pgg = mysqli_fetch_array($qu)){
		$hsl = $hsl.'
								<li>
                                    <div class="row">
                                        <div class="col-md-2 col-md-offset-1 col-xs-5 col-xs-offset-1">
                                            <img src="../daftar/oge.png" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                        </div>
                                        <div class="col-md-6 col-xs-4 description">
                                            <h5>'.$pgg['nama'].' | '.$pgg['nope'].'<br /><small> '.$pgg['tgl_daftar'].'</small></h5>
                                        </div>
                                        <div class="col-md-2 col-xs-2">
                                            <a class="btn btn-icon btn-danger" href="https://api.whatsapp.com/send?phone='.ke_wa($pgg['nope']).'&text=Hallo%20'.$pgg['nama'].'%2C%20"><i class="fa fa-phone-square"></i></a>

                                        </div>
                                    </div>
                                </li>
			';

	}
	for($i=0;$i<=$jmlhalaman;$i++){
		if ($i != $halaman){
		 $a = '<li><a href="anti.php?t=mt&h='.$i.'">'.$i.'</a></li>';

		}
		else{
		 $a = '<li class="active"><a>'.$i.'</a></li>';
		}
		$tabelh=$tabelh.$a;

	}
	$hter = $jmlhalaman +1;
	if ($hter != $halaman){
		 $a = '<li><a href="anti.php?t=mt&h='.$hter.'">'.$hter.'</a></li>';

		}
		else{
		 $a = '<li class="active"><a>'.$hter.'</a></li>';
		}
	$tabelh=$tabelh.$a;
	$halm = '<ul class="pagination pagination-info">'.$tabelh.'</ul>';
	return $hsl.$halm;

}
function pencairan($con,$usr,$fbid){
	//cek no_rek
	$nm = 'dbank_'.$usr;
	$akunb = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `parameter` WHERE `nama`='$nm'"));
	$akunbrek = explode('_',$akunb['param1']);
	$t_riwayat=''; $ada_norek='no'; $tabel=''; $no=1;
	if($akunb['nama']){
	$ada_norek ='ya';

	//tabel riwayat
	$qri = mysqli_query($con,"SELECT `nominal`,`status`,`group_pencairan`,`bukti_transfer` FROM `pencairan` WHERE `username`='$usr' ORDER BY `pencairan`.`id_pencairan` ASC");
	while($data = mysqli_fetch_array($qri)){
		$tabel = $tabel.'<tr>
		<td>'.$no.'</td>
		<td>'.$data['group_pencairan'].'</td>
		<td>'.rp($data['nominal']).'</td>
		<td>'.$data['status'].'</td>
		<td>'.$data['bukti_transfer'].'</td>
		</tr>';
		$no++;
	}
	$t_riwayat ='
	<div class="row">
                       <div class="col-md-6 col-xs-12 text-center" >
					   <div class="info info-horizontal">
                            <div class="icon">

                            </div>
                            <div class="description">
                                <p>'.$akunb['param2'].' | '.$akunbrek[1].' | a.n '.$akunb['param3'].'
                            </div>
                       </div>
						<div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Periode</th>
                                    <th>Pencairan</th>
                                    <th>Status</th>
									<th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
							'.$tabel.'

                             </tbody>
                        </table>
                        </div>
					   </div>
					</div>
	';
	}
	//tampilkan riwayat
	return array('norek' => $ada_norek, 'tabel_riwayat' => $t_riwayat);
}
function getUserByFbId($con,$fbid){
	if (!isset($fbid) || !is_numeric($fbid)) {
		return 'invalid fb id';
	} else {
		$s = 'SELECT * FROM pengguna WHERE id_fb='.$fbid;
		$e = mysqli_query($con,$s);
		$n = mysqli_num_rows($e);
		if($n<=0){
			return 'fb id is not found';
		} else {
			$r=mysqli_fetch_assoc($e);
			return $r;
		}
	}
}
//Inisialisasi Google Analytics
function initializeAnalytics(){
    // Creates and returns the Analytics Reporting service object.

    // Use the developers console and download your service account
    // credentials in JSON format. Place them in this directory or
    // change the key file location if necessary.
    $KEY_FILE_LOCATION = __DIR__ . '/client_secrets.json';

    // Create and configure a new client object.
    $client = new Google_Client();
    // $client->setApplicationName("Hello Analytics Reporting");
    $client->setAuthConfig($KEY_FILE_LOCATION);
    $client->setScopes(Google_Service_Analytics::ANALYTICS_READONLY);

    $analytics = new Google_Service_AnalyticsReporting($client);

    return $analytics;
}
// Load the Google API PHP Client Library(Mengambil data hari ini)
function getReport1($analytics) {
  // Replace with your view ID, for example XXXX.
  $VIEW_ID = "162575063";

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("today");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:pageviews");
  $sessions->setAlias("Kunjungan Hari Ini");

  $browser = new Google_Service_AnalyticsReporting_Dimension();
  $browser->setName("ga:hostname");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setDimensions(array($browser));
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}
// Load the Google API PHP Client Library(Mengambil data bulan ini)
function getReport2($analytics) {
  // Replace with your view ID, for example XXXX.
  $VIEW_ID = "162575063";

  $awal = date("Y-m-01");
  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate($awal);
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:pageviews");
  $sessions->setAlias("Kunjungan Bulan ini");

  $browser = new Google_Service_AnalyticsReporting_Dimension();
  $browser->setName("ga:hostname");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setDimensions(array($browser));
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}
// Load the Google API PHP Client Library(Mengambil data minggu ini)
function getReport3($analytics) {
  // Replace with your view ID, for example XXXX.
  $VIEW_ID = "162575063";

  // Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("6daysAgo");
  $dateRange->setEndDate("today");

  // Create the Metrics object.
  $sessions = new Google_Service_AnalyticsReporting_Metric();
  $sessions->setExpression("ga:pageviews");
  $sessions->setAlias("Kunjungan Minggu Ini");

  $browser = new Google_Service_AnalyticsReporting_Dimension();
  $browser->setName("ga:hostname");

  // Create the ReportRequest object.
  $request = new Google_Service_AnalyticsReporting_ReportRequest();
  $request->setViewId($VIEW_ID);
  $request->setDateRanges($dateRange);
  $request->setDimensions(array($browser));
  $request->setMetrics(array($sessions));

  $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
  $body->setReportRequests( array( $request) );
  return $analytics->reports->batchGet( $body );
}
//Menampilkan hasil dari google analytics
function printResults($reports,$user) {
  for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
    $report = $reports[ $reportIndex ];
    $header = $report->getColumnHeader();
    $dimensionHeaders = $header->getDimensions();
    $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
    $rows = $report->getData()->getRows();

    for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
      $row = $rows[ $rowIndex ];
      $dimensions = $row->getDimensions();
      $metrics = $row->getMetrics();
        for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
            //print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
            if ($dimensions[$i] == $user){
                //print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
                for ($j = 0; $j < count($metrics); $j++) {
                    $values = $metrics[$j]->getValues();
                    for ($k = 0; $k < count($values); $k++) {
                      $entry = $metricHeaders[$k];
                      //print($entry->getName() . ": " . $values[$k] . "\n");
                      //print($values[$k]);
                      $ambil=$values[$k];
                    }
                }
            }
        }
    }
  }
  return $ambil;
}
//Lihat Jumlah Kunjungan
function kunjungan($con,$db,$user){
	$analytics = initializeAnalytics();

    // Call the Analytics Reporting API V4.
    $response1 = getReport1($analytics);
    $response2 = getReport2($analytics);
    $response3 = getReport3($analytics);

    $hari=printResults($response1,$user);
    $bulan=printResults($response2,$user);
    $minggu=printResults($response3,$user);

    if (isset($hari)){
        $hari = $hari;
    } else {
        $hari = 0;
    }

    if (isset($bulan)){
        $bulan = $bulan;
    } else {
        $bulan = 0;
    }

    if (isset($minggu)){
        $minggu = $minggu;
    } else {
        $minggu = 0;
    }


	$hsl = $hsl.'
		<div class="row">
			<div class="col-lg-12 col-xs-12">
				<div class="small-box" style="background-color:#af9c8b; color:#FFFFFF">
					<div class="inner" style="text-align:center">
						<h3>'.$hari.'<sup style="font-size: 18px"> Orang</sup></h3>
					</div>
					<div class="small-box-footer">
					  Jumlah Kunjungan Hari ini
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-xs-12">
				<div class="small-box" style="background-color:#af9c8b; color:#FFFFFF">
					<div class="inner" style="text-align:center">
						<h3>'.$bulan.'<sup style="font-size: 18px"> Orang</sup></h3>
					</div>
					<div class="small-box-footer">
					  Jumlah Kunjungan Bulan ini
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-xs-12">
				<div class="small-box" style="background-color:#af9c8b; color:#FFFFFF">
					<div class="inner" style="text-align:center">
						<h3>'.$minggu.'<sup style="font-size: 18px"> Orang</sup></h3>
					</div>
					<div class="small-box-footer">
					  Jumlah Kunjungan Minggu ini
					</div>
				</div>
			</div>
		</div>';
	return $hsl;
}
?>
