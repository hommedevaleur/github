<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>
<link rel="stylesheet" type="text/css" href="/css/result-light.css">
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<script type="text/javascript">
	$(window).load(function() {
		$(".carousel .item").each(function() {
		var i = $(this).next();
		i.length || (i = $(this).siblings(":first")),
		i.children(":first-child").clone().appendTo($(this));
				
	    for (var n = 0; n < 2; n++)(i = i.next()).length ||
			(i = $(this).siblings(":first")),
			i.children(":first-child").clone().appendTo($(this))
		})
	});
</script>
</head>

<body>
<div class="container">
    <div class="carousel slide" id="myCarousel">
		<div class="carousel-inner">
            <!--1-->
            <div class="item active">
                <div class="col-xs-3">
                    <a href="#"> <img src="https://media.geeksforgeeks.org/wp-content/uploads/20190709143904/391.png" class="img-responsive"></a>
                </div>
            </div>
            <!--2-->
			<div class="item">
				<div class="col-xs-3"><a href="#">
						<img src="https://media.geeksforgeeks.org/wp-content/uploads/20190709143850/1382.png" class="img-responsive"></a>
				</div>
			</div>
        

		</div> <!--//CAROUSSEL INNER-->
<a class="left carousel-control" href="#myCarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
<a class="right carousel-control" href="#myCarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
	</div><!--//CAROUSSEL INNER-->
</div>
</body>
</html>
