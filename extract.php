<?php
$url = $_GET['url'];
//var_dump($url); 
parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
echo $my_array_of_vars['v'];    
  // Output: C4kxS1ksqtw
?>
<html>
<body>
name is: <?php echo $_GET['url']; ?><br />
<br />
Do you like this website? <?php echo $_GET['wel']; ?><br />
<br />
Comments:<br />
<?php echo $_POST['comments']; ?>
</body>
</html> 
