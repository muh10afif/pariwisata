<?php 

$a = date('dmY').$jenis_report;

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename= $a.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

<!-- content -->
<?php echo @$_content; ?> <!-- headerContent --><!-- mainContent -->

</body>
</html>