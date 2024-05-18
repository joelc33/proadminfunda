<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>

    <title>PROADMIN</title>
<!--<link rel="shortcut icon" href="<?= image_path('favicon.ico'); ?>" />-->
        <?php echo use_stylesheet("app.css") ?>
</head>
  <body background="#FFFFFF" >
    <style type="text/css">
        h1 {font: normal 60px tahoma, arial, verdana;color: #E1E1E1;}
        h2 {font: normal 20px tahoma, arial, verdana;color: #E1E1E1;}
        h2 a {text-decoration: none;color: #E1E1E1;}
        .x-window-mc {background-color : #F4F4F4 !important;}
    </style>
    
<!-- Start Page Loading -->
<div id="loader-wrapper">
  <div id="loader"></div>
</div>
<!-- End Page Loading -->

<?= javascript_include_tag('app.js'); ?>
<link rel="stylesheet" type="text/css" href="/proadmin/web/js/ext-3.2.1/resources/css/ext-all.css" />

<script>
$(function () {
  
$.backstretch([
"<?= image_path('web_1.jpg'); ?>",
"<?= image_path('web_2.jpg'); ?>"
  ], {duration: 3000, fade: 750});

});
</script>
      <? echo $sf_content; ?>
       <div id="winValidar">
          <div id="msgValidar" style="margin-bottom: 20px; font-size: 12px; font-weight: bold; color:#444; display: none">
            Acceso para usuarios registrados
          </div>
           <div id="principal" align="center" style="padding-bottom: 1%">
                     <!--<img src="<?= image_path('admbpm.png'); ?>"  width="150" style="position: absolute; top: 70%; right: 6px;" /> -->
            </div>
       </div>
  </body>
 </html>
