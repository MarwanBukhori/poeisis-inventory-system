<!--
  Matric Number: A174856
  Name: Marwan Bukhori 
-->

<?php
require 'database.php';
$user_name = $_SESSION["username"];
$staff_role = $_SESSION["staff_role"];

if (!isset($_SESSION['loggedin']))
    header("LOCATION: login.php");

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Poiesis Animal System</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
	<link rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/@splidejs/splide@2.4.21/dist/css/themes/splide-sea-green.min.css">
	<link rel="stylesheet" href="style/index.css">

	<style type="text/css">
		/*body{
	 background-color: lightblue;
	 }*/
		.splide__slide {
			transform: scale(0.8, 0.8);
			/* sets all slides to a scaling of 0.8 (80%) */
			display: inline-flex;
			/* used for all slides vertical align center */
			vertical-align: middle;
			/* used for all slides vertical align center */
		}

		.splide__slide.is-active {
			transform: scale(1, 1);
			/* sets the active slide to scaling of 1 (100%) */
		}

		figure {
			display: table;
		}

		figcaption {
			display: table-caption;
			caption-side: bottom;
		}

		li {
			width: auto;
		}
	</style>
</head>

<body>

	<div class="testing">
		<section class="showcase">
			<header>
				<h2 class="logo">POIESIS ANIMAL</h2>
				<div class="toggle"></div>
			</header>
			<video src="video1.mp4" muted loop autoplay></video>
			<div class="overlay"></div>
			<div class="text">
				<h2>Never Stop To </h2>
				<h3>Exploring The World</h3>


				<form action="#" method="POST" class="search-bar" id="searchForm">
						<input type="text"  id="inputSearch" name="search"
							 autocomplete="off" pattern=".*\S.*" required>
						<button class="search-btn" type="submit">
							<span>Search</span>
						</button>
				</form>

			</div>

			<ul class="social">
				<li>
					<a href="#"><img src="https://i.ibb.co/x7P24fL/facebook.png"></a>
				</li>
				<li>
					<a href="#"><img src="https://i.ibb.co/Wnxq2Nq/twitter.png"></a>
				</li>
				<li>
					<a href="#"><img src="https://i.ibb.co/ySwtH4B/instagram.png"></a>
				</li>

				<li>
					<a href="#"><h2 id="username"><?php echo $user_name ; ?> ( <?php echo $staff_role ; ?> ) </h2></a>
				</li>
			</ul>
		</section>

		<div class="menu">
			<ul>
				<li><a href="products.php">Products</a></li>
				<li><a href="customers.php">Customers</a></li>
				<li><a href="staffs.php">Staffs</a></li>
				<li><a href="orders.php">Orders</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
	</div> <!-- / testing -->




	<!-- / result -->

	<section id="resultSection" class="container resultList" style="padding: 20px; display: none;">
		<div class="text-center">
			<h2>Result</h2>
			<p>Found <span class="result-count">0</span> results.</p>
		</div>

		<!-- <div class="splide">
			<div class="splide__track">
				<ul class="splide__list"><!-tempat masuk card-></ul>
			</div>
			<div class="splide__progress">
				<div class="splide__progress__bar"></div>
			</div> -->
		<div class="container">

			<div class="row list-item">



			</div>
			<!--<div class="splide__autoplay">
			<button class="splide__play">Play</button>
			<button class="splide__pause">Pause</button>
		</div> -->
			<!--<script class="scp">
			var splide = new Splide('.splide', {
				type: 'loop',
				perPage: 2,
				autoplay: true,
				pauseOnHover: false,
				trimSpace: false,
				breakpoints: {
					640: {
						perPage: 4,
					},
				},
				//gap        : 10,
				focus: 'center',
				pagination: true,
			}).mount();
		</script> -->
		</div>

	</section>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
	<script>
		$("#searchForm").submit(function (e) {
			e.preventDefault();

			var input = $("#inputSearch");
			var val = input.val();

			input.parent().removeClass('has-error');
			input.parent().find("#helpBlock2").text("");

			if (val.length > 2) {
				//&& (val.split(" ").length==1 || val.split(" ").length==3)
				$.ajax({
					url: 'search.php',
					type: 'get',
					dataType: 'json',
					data: {
						search: val
					},
					beforeSend: function () {
						$("body").addClass('loading');
						input.addClass('disabled');
						//$( ".scp" ).unbind();

					},
					success: function (res) {
						$('.list-item').empty();
						if (res.status == 200) {
							//  console.log(res.data);
							$(".result-count").text(res.data.length);

							//if ($('.scp')[0]){
							//$('.splide__list').empty();
							//$('.scp').remove();
							//}
							$.each(res.data, function (idx, data) {
								if (data.fld_product_image === '')
									data.fld_product_image = data.fld_product_id + '.png';

								// $('.splide__list').append(
								// 	`<li class="splide__slide">
								// 	<div class="splide__slide__container text-center">
								// 	<figure class="figure">
								// 	<img src="products/${data.fld_product_image}" alt="${data.fld_product_name}" style="height: 200px;" class="figure-img img-fluid rounded">
								// 	<figcaption class="figure-caption">${data.fld_product_name}</figcaption>
								// 	</figure>
								// 	<a href="products_details.php?pid=${data.fld_product_id}" class="btn btn-primary" role="button">View</a>
								// 	</div>
								// 	</li>
								// 	`);

								$('.list-item').append(`<div class="col-md-4">
                                <div class="thumbnail thumbnail-dark">
                                <img src="products/${data.fld_product_image}" alt="${data.fld_product_name}" style="height: 345px;" class="mx-auto d-block rounded">
                                <div class="caption text-center">
                                <h3>${data.fld_product_name}</h3>
                                <p>
                                <a href="products_details.php?pid=${data.fld_product_id}" class="btn btn-primary" role="button">View</a>
                                </p>
                                </div>
                                </div>
                                </div>`);
							});
							$(".scp").bind();
							/*$('.splide__list').append(
								`<script class="scp">
								var splide = new Splide( '.splide' ,{
									type        : 'loop',
									perPage     : 2,
									autoplay    : true,
									pauseOnHover: false,
									trimSpace : false,
									breakpoints: {
										640: {
											perPage: 4,
										},
									},
									focus      : 'center',
								}).mount();
								<\/script>`);*/

							$(".resultList").show("slow", function () {
								$("body").removeClass('loading');
							});
							$('html, body').animate({
								scrollTop: $("#resultSection").offset().top
							}, 500);
						} else {
							console.log(res.data);
						}
					},
					complete: function () {
						input.removeClass('disabled');
					}
				});
			} else {
				input.parent().addClass("has-error");
				input.parent().find("#helpBlock2").text("Please enter more than 2 characters.");
				$('.splide__list').empty();
			}
		});
	</script>
	<!-- <script class="scp">
							var splide = new Splide( '.splide' ,{
								type        : 'loop',
								perPage     : 2,
								autoplay    : true,
								pauseOnHover: false,
								trimSpace : false,
								breakpoints: {
									640: {
										perPage: 4,
									},
								},
								//gap        : 10,
								focus      : 'center',
								//pagination:false
							}).mount();
							</script> -->
	<!--div id="img">
		<script type="text/javascript">
			var bd = document.body;
			var suns = document.querySelector("#img")
			function rot(event) {
				var w = window.innerWidth / 2;
				var x = event.clientX;
				if (x > w + 100) {
					suns.style.transform = "perspective(1000px) rotateY(30deg)";
				}
				if (x > w - 100 && x < w + 100) {
					suns.style.transform = "perspective(1000px) rotateY(0deg)";
				}
				if (x < w - 100) {
					suns.style.transform = "perspective(1000px) rotateY(-30deg)";
				}
			}
			bd.addEventListener("mousemove", rot);
		</script>
	</div-->
	<script src=js/index.js> </script> </body> </html>