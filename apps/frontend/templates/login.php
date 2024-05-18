<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Sisprot">
	<meta name="keywords" content="Sistema, Sisprot">
	<meta name="author" content="Sisprot">
	<title>PROADMIN | Iniciar Sesión
</title>

<!--    <link rel="shortcut icon" href="<?php echo image_path('favicon.ico'); ?>"> -->
    <?php echo use_stylesheet("admbpm.css") ?>
    <?php echo use_stylesheet("themes/fixed-menu/login.css") ?>
</head>


<body class="cyan">

    <!-- Start Page Loading -->
    <div id="loader-wrapper">
      <div id="loader"></div>
          </div>
    <!-- End Page Loading -->

<?php echo $sf_content; ?>
    

<!-- Scripts -->
<?php echo javascript_include_tag('admbpm.js'); ?>
<script>
$(function () {
  
$(".cyan").backstretch([
"<?php echo image_path('fondo_protrib.png'); ?>"
//"<?php echo image_path('web_1.jpg'); ?>"
  ], {duration: 3000, fade: 750});

});
</script>

 <img src="<?php echo image_path('Imagen1.png'); ?>"  width="200" style="position: absolute; top: 70%; right: 6px;" />
</body>


</html>
