<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Login</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="<?=base_url()?>bower_components/bootstrap/dist/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?=base_url()?>bower_components/font-awesome/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="<?=base_url()?>bower_components/Ionicons/css/ionicons.min.css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- jQuery 3 -->
		<script src="<?=base_url()?>bower_components/jquery/dist/jquery.min.js"></script>		
	</head>

	<body>
		<button id="tstButton">Test</button>	

		<script type="text/javascript">
			$(function(){
				$("#tstButton").click(function(){
					var data = {
						"<?= $this->security->get_csrf_token_name() ?>":"<?= $this->security->get_csrf_hash() ?>"
					}

					$.ajax({
						url:"<?=site_url()?>test/test_ajax",
						method: "POST",
						data: data,
					}).done(function(resp){
						
					});
				});
			});

		</script>
		<!-- jQuery UI 1.11.4 -->
		<script src="<?=base_url()?>bower_components/jquery-ui/jquery-ui.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="<?=base_url()?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	</body>
</html>
