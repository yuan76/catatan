<?php session_start();
include "../conf.php"; include "fungsi.php";
$fbid = $_SESSION['FBID'];
//$nama_lengkap = $_SESSION['FULLNAME'];
$query = mysqli_query($con,"select * FROM pengguna WHERE id_fb='$fbid'");
    while ($data=mysqli_fetch_assoc($query)){
		$nama_lengkap=$data['nama_dpn']." ".$data['nama_blk'];
		$username=$data['username'];
		$jenis=$data['mlm_type'];
	}

$userByFbId = getUserByFbId($con,$fbid);
// print_r($dt);exit();

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

		<style media="screen">
			.imageOption{
				height: 150px;
				border: 5px dashed #CCC;
				/* border: 5px dashed #CCC; */
				cursor: pointer;
				opacity: .3;
			}
			.imageOption.active{
				border: 5px solid orange;
				/* border: 5px dashed #000; */
				opacity: 1;
			}
			.imageOption:hover {
				opacity: 1;
			}


			/* .container .btn { */
			.divCanvas .downloadBtn {
			  position: absolute;
			  top: 100%;
			  left: 50%;
			  transform: translate(-50%, -50%);
			  -ms-transform: translate(-50%, -50%);
			  background-color: #555;
			  color: white;
			  font-size: 16px;
			  padding: 12px 24px;
			  border: none;
			  cursor: pointer;
			  border-radius: 5px;
				opacity: 0.5;
			}
			.downloadBtn:hover {
				opacity: 1;
			}
		</style>
	</head>

	<body class="search">
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
	          <a class="navbar-brand" href="#"><?php echo "Tambah Foto Frame"; ?>
	        </div>

	        <!-- Collect the nav links, forms, and other content for toggling -->
	        <div class="collapse navbar-collapse navbar-white-collapse" id="navigation-example-2">
	          <ul class="nav navbar-nav navbar-right">
                <li><a class="btn btn-simple btn-neutral">SuksesFamily</a></li>
                <li><a class="btn btn-simple btn-neutral">2017</a></li>
                <li><a  target="_blank" class="btn btn-simple btn-neutral"><i class="fa fa-twitter"></i> Twitter </a></li>
                <li><a  target="_blank" class="btn btn-simple btn-neutral"><i class="fa fa-facebook"></i> Facebook </a></li>
	           </ul>
	        </div><!-- /.navbar-collapse -->
	      </div><!-- /.container-->
	    </nav>

	    <div class="wrapper">
	        <div class="main">
	            <div class="section section-white section-search">
	                <div class="container">
										<div class="row">
													<!-- preview result image
													<div id="exTab1" class="containerx"> -->
														<div id="imageDiv" class="col-xs-12 text-center">
															 <ul  class="nav nav-pills">
																<li class="active"> <a  href="#1a" data-toggle="tab">Promote</a></li>
																<li><a href="#2a" data-toggle="tab">Profile</a></li>
															</ul>

														<div class="tab-content xclearfix">

															<!-- promote content -->
														  <div class="tab-pane active" id="1a">

																<br>
																<!-- <label>Promote Picture</label> -->

																	<!-- preview options -->
																	<div id="imageOptions" class="form-group">
																		<?php
																			$sql = "SELECT * FROM parameter WHERE param1 = 'promote' and param2='$jenis' ORDER BY nama ASC";
																			$exe = mysqli_query($con,$sql);
																			$i=0;
																			while ($res=mysqli_fetch_assoc($exe)) {
																				$param3s = explode(',',trim($res['param3'],' '));
																				$x= $param3s[0];
																				$y= $param3s[1];
																				$w= $param3s[2];
																				$h= $param3s[3];
																				$xx= $param3s[4];
																				$yy= $param3s[5];
																				// pr($x);
																					echo'<img onclick="promoteOptionClick(this);"
																						src="../uploads/promote_template/'.$res['nama'].'"
																						tipe="'.$res['param1'].'"
																						profileX="'.$x.'"
																						profileY="'.$y.'"
																						profileW="'.$w.'"
																						profileH="'.$h.'"
																						textX="'.$xx.'"
																						textY="'.$yy.'"
																						class="imageOption"
																						data-design="0"
																					/>';
																					// class="imageOption '.($i==0?'active':'').'"
																					$i++;
																			}
																		 ?>
																	</div>

																	<div class="form-group">
																		<div>
																			<img id="promotePreview" width="250" src="../uploads/no_preview.png" alt="" />
																		</div>

																		<div class="divCanvas">
																			<a id="promoteDownload" style="display:none;" href="#" class="downloadBtn">Download</a>
																			<canvas id="promoteCanvas"></canvas>
																		</div>
																	</div>

															</div>

															<!-- profile content -->
															<div class="tab-pane" id="2a">
																<br>
																<!-- <label>Promote Picture</label> -->

																	<!-- preview options -->
																	<div id="imageOptions" class="form-group">
																		<?php
																			$sql2 = "SELECT * FROM parameter WHERE param1 = 'frame' and param2='$jenis' ORDER BY nama ASC";
																			$exe2 = mysqli_query($con,$sql2);
																			// pr($exe2);
																			$i2=0;
																			while ($res2=mysqli_fetch_assoc($exe2)) {
																					echo'<img onclick="frameOptionClick(this);"
																						src="../uploads/frame_template/'.$res2['nama'].'"
																						class="imageOption"
																						data-design="0"
																						frame_id="'.$res2['id_param'].'"
																					/>';
																					$i2++;
																			}
																		 ?>
																	</div>

																	<div class="form-group">
																		<div>
																			<img id="framePreview" width="250" src="../uploads/no_preview.png" alt="" />
																			<input type="hidden" name="id_frame" id="id_frame" >
																			<input type="hidden" name="foto_profile" id="foto_profile" >
																		</div>

																		<div class="divCanvas">
																			<a id="frameDownload" style="display:none;" href="#" class="downloadBtn">Download</a>
																			<canvas id="frameCanvas"></canvas>
																		</div>
																	</div>

															</div>

														</div>
												  </div>




	                <!--</div>-->
		            </div>
	        </div>
	    </div>

				<footer class="footer-demo section-white-gray">
		        <div class="container">
				<nav class="pull-left col-md-10">
                <ul>
					<li> </li>
                    <li class="col-lg-1 col-xs-12 text-center" id="panel2">

                        <a href="../catatan/anti.php?t=dp">
                            Komisi
                        </a>

                    </li>
                    <li class="col-lg-1 col-xs-12 text-center" id="panel3">

                        <a href="../catatan/anti.php?t=mt">
                           CaMit
                        </a>

                    </li>
                    <li class="col-lg-1 col-xs-12 text-center" id="panel4">

                        <a href="../catatan/anti.php?b=">
                            Home
                        </a>

                    </li>
					<li class="col-lg-1 col-xs-12 text-center" id="panel5">

						<a href="../daftar/pembayaran.php">
							Upgrade
						</a>

					</li>
					<li class="col-lg-1 col-xs-12 text-center" id="panel6">

						 <a href="../catatan/anti.php?t=kun">
							Kunjungan
						</a>

					</li>
					<li class="col-lg-1 col-xs-12 text-center" id="panel7">

						 <a href="../catatan/canvas.php">
							FrameFoto
						</a>

					</li>
                </ul>
            </nav>

		      <div class="copyright pull-right">
		          &copy; DTS Jakarta
		      </div>
		  </div>
		</footer>

	</body>

	<script>
		$(document).ready(function(){
			console.log('ready');
		});
// ---------
		function downloadCanvas(link, canvasId, filename) {
		    link.href = document.getElementById(canvasId).toDataURL();
		    link.download = filename;
		}
// ---------
		var pcanvas= document.getElementById('promoteCanvas');
		var pcontext= pcanvas.getContext('2d');
		var pimgs=[];
		var pimagesOK=0;
		var pimageURLs	= [];

		var pimgUrl1 = '';
		var pimgUrl2 = '';
		var pe,ptipe,pprofile_x,pprofile_y,ptext_x,ptext_y;
		var pObjProp=[];

		document.getElementById('promoteDownload').addEventListener('click', function() {
		    downloadCanvas(this, 'promoteCanvas',  'promote_<?php echo $username ?>.png');
		}, false);

		function promoteOptionClick(el) {
			pimageURLs=[];
			pObjProp=[];
			console.log('promoteOptionClick');
			$(".imageOption.active").removeClass("active");
			$(el).addClass("active");

			pe = el;
			src = $(el).attr('src');
			pprofile_x = $(el).attr('profileX');
			pprofile_y	= $(el).attr('profileY');
			profile_w = $(el).attr('profileW');
			profile_h = $(el).attr('profileH');
			ptext_x = $(el).attr('textX');
			ptext_y = $(el).attr('textY');
			pObjProp.push(pprofile_x);
			pObjProp.push(pprofile_y);
			pObjProp.push(profile_w);
			pObjProp.push(profile_h);
			pObjProp.push(ptext_x);
			pObjProp.push(ptext_y);

			//var profUrl = 'https://graph.facebook.com/'+<?php echo $fbid; ?>+'/picture?type=large';
			var profUrl = '../uploads/poto/'+<?php echo $fbid; ?>+'.jpg';
			var templUrl = src ;
			pimageURLs.push(templUrl); // layer 1 (bottom) : promote
			pimageURLs.push(profUrl); // layer 2 (top) : profile
			promoteLoadImage(promoteObjProp);
		}

		function promoteObjProp() {
			console.log('promoteObjProp');
			console.log(pObjProp);
			pcanvas.width = pimgs[0].naturalWidth;
			pcanvas.height = pimgs[0].naturalHeight;

		 	var imgX = pObjProp[0];
		 	var imgY = pObjProp[1];
		 	var imgW = pObjProp[2];
		 	var imgH = pObjProp[3];
		 	var txtX = pObjProp[4];
		 	var txtY = pObjProp[5];
			pcontext.drawImage(pimgs[0],0,0);
			pcontext.drawImage(pimgs[1],imgX,imgY,imgW,imgH);
			pcontext.fillText("<?php echo $nama_lengkap;?>", txtX, txtY); // 400
			pcontext.fillText("<?php echo $userByFbId['no_wa'];?>", txtX,parseFloat(txtY)+20); // 420
			pcontext.fillText("http://"+"<?php echo $userByFbId['username'];?>"+".sukses.family", txtX,parseFloat(txtY)+40); //440
		}

		function promoteLoadImage(promoteObjPropx) {
			console.log('promoteLoadImage');
			console.log('-- sebelum hapus ');
				console.log(pimgs);
				console.log(pimageURLs);
			pimgs=[];
			console.log('-- setelah hapus ');
				console.log(pimgs);
				console.log(pimageURLs);

			$('#promotePreview').attr('style','display:none');
			// context.clearRect(0, 0, canvas.width, canvas.height);

			console.log(pimageURLs.length);
			for (var i=0; i<pimageURLs.length; i++) { // iterate through the pimageURLs array and create new images for each
				var img = new Image(); // create a new image an push it into the pimgs[] array
				pimgs.push(img);

				img.crossOrigin = "anonymous";
				img.onload = function(){// when this image loads, call this img.onload
					pimagesOK++; // this img loaded, increment the image counter
					if (pimagesOK>=pimageURLs.length ) { // if we've loaded all images, call the callback
						promoteObjPropx();
						$('#promoteDownload').removeAttr('style');
					}
				};

				img.onerror=function(){ // notify if there's an error
					alert("failed load profile");
				}

				img.src = pimageURLs[i]; // set img properties
			}
		}

		function promoteResetForm () {
			$('#promoteCanvas').html('');
			$('#promotePreview').removeAttr('style');

			pimgs=[];
			pimagesOK=0;
			pimageURLs	= [];
			pimgUrl1 = '';
			pimgUrl2 = '';
			pe,ptipe='',pprofile_x='',pprofile_y='';
			pObjProp=[];
		}

// profile frame
		var fcanvas= document.getElementById('frameCanvas');
		var fcontext= fcanvas.getContext('2d');
		var fimgs=[];
		var fimagesOK=0;
		var fimageURLs	= [];

		var fimgUrl1 = '';
		var fimgUrl2 = '';
		var pe,ftipe,fprofile_x,fprofile_y,ftext_x,ftext_y;
		var fObjProp=[];

		function frameOptionClick(el) {
			fimageURLs=[];
			fObjProp=[];
			console.log('frameOptionClick');
			$(".imageOption.active").removeClass("active");
			$(el).addClass("active");

			$('#id_frame').val(
				$(el).attr('frame_id')
			);

			var frameDataURL = fcanvas.toDataURL('image/png');
			$('#foto_profile').val(frameDataURL);


			fe = el;
			src = $(el).attr('src');
			fprofile_x = $(el).attr('profileX');
			fprofile_y	= $(el).attr('profileY');
			profile_w = $(el).attr('profileW');
			profile_h = $(el).attr('profileH');
			ftext_x = $(el).attr('textX');
			ftext_y = $(el).attr('textY');
			fObjProp.push(fprofile_x);
			fObjProp.push(fprofile_y);
			fObjProp.push(profile_w);
			fObjProp.push(profile_h);
			fObjProp.push(ftext_x);
			fObjProp.push(ftext_y);

			//var profUrl = 'https://graph.facebook.com/'+<?php echo $fbid; ?>+'/picture?type=large';
			var profUrl = '../uploads/poto/'+<?php echo $fbid; ?>+'.jpg';
			var templUrl = src ;
			fimageURLs.push(profUrl); // layer 1 (bottom) : prof
			fimageURLs.push(templUrl); // layer 2 (top) : frame
			frameLoadImage(frameObjProp);
		}

		function frameObjProp() {
			console.log('frameObjProp');
			console.log(fObjProp);
			fcanvas.width = fimgs[0].naturalWidth;
			fcanvas.height = fimgs[0].naturalHeight;
			console.log(fcanvas.width);
			console.log(fimgs[1].naturalWidth);

			fcontext.drawImage(fimgs[0],0,0);
			fcontext.drawImage(fimgs[1],0,0,fcanvas.width,fcanvas.height);
		}

		function frameLoadImage(frameObjPropx) {
			console.log('frameLoadImage');
			console.log('-- sebelum hapus ');
				console.log(fimgs);
				console.log(fimageURLs);
			fimgs=[];
			console.log('-- setelah hapus ');
				console.log(fimgs);
				console.log(fimageURLs);

			$('#framePreview').attr('style','display:none');
			// context.clearRect(0, 0, canvas.width, canvas.height);

			console.log(fimageURLs.length);
			for (var i=0; i<fimageURLs.length; i++) { // iterate through the fimageURLs array and create new images for each
				var img = new Image(); // create a new image an push it into the fimgs[] array
				fimgs.push(img);

				img.crossOrigin = "anonymous";
				img.onload = function(){// when this image loads, call this img.onload
					fimagesOK++; // this img loaded, increment the image counter
					if (fimagesOK>=fimageURLs.length ) { // if we've loaded all images, call the callback
						frameObjPropx();
						$('#frameDownload').removeAttr('style');
					}
				};

				img.onerror=function(){ // notify if there's an error
					alert("failed load profile");
				}

				img.src = fimageURLs[i]; // set img properties
			}
		}

		function frameResetForm () {
			$('#frameCanvas').html('');
			$('#framePreview').removeAttr('style');

			fimgs=[];
			fimagesOK=0;
			fimageURLs	= [];
			fimgUrl1 = '';
			fimgUrl2 = '';
			fe,ftipe='',fprofile_x='',fprofile_y='';
			fObjProp=[];
		}

		document.getElementById('frameDownload').addEventListener('click', function() {
		    downloadCanvas(this, 'frameCanvas',  'frame_<?php echo $username ?>.png');
		}, false);

		function frameSave() {
			// alert('hai');
			$.ajax({
				url:'anti_proses.php',
			  type:'post',
			  data: {
			    'photo':$('#foto_profile').val(),
					'dataForm':$('#frameForm').serialize()
			  },
				dataType:'json',
				success:function(dt){
					console.log(dt);
					location.reload();
				}
			});
		}

	</script>

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
