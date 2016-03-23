<?php
//
// Dit gaat al genoeg ver dat er een lijst of file geupload kan worden.
// Deze krijgen dan thumbnails (zou dan nog playable moeten zijn:
// <object width="425" height="350" data="http://www.youtube.com/v/Ahg6qcgoay4" type="application/x-shockwave-flash"><param name="src" value="http://www.youtube.com/v/Ahg6qcgoay4" /></object>
// als html
// size kan nog aangepast worden.
// daarna adding via de API
function get_embed($provider, $url, $max_width = '', $max_height = ''){
    $providers = array(
        'youtube' => 'http://www.youtube.com/oembed'
        /* you can add support for more providers here */
    );

    if(!isset($providers[$provider])){
        return 'Invalid provider!';
    }

    $movie_data_json = @file_get_contents(
        $providers[$provider] . '?url=' . urlencode($url) . 
        "&maxwidth={$max_width}&maxheight={$max_height}&format=json"
    );

    if(!$movie_data_json){
        $error = error_get_last();
        /* remove the PHP stuff from the error and show only the HTTP error message */
        $error_message = preg_replace('/.*: (.*)/', '$1', $error['message']);
	$query = parse_url($this->url, PHP_URL_QUERY);
	$arr = explode('=', $query);
	$index = array_search('v', $arr);

    if ($index !== false) {
        if (isset($arr[$index++])) {
            $string = $arr[$index++];
            if (($amp = strpos($string, '&')) !== false) {
                return substr($string, 0, $amp);
            } else {
                echo $string;
            }
	}
    } else {
        return $error_message;
    }
    }else{
        $movie_data = json_decode($movie_data_json, true);
        return $movie_data['html'];
    }
}

$text_box = trim($_POST['text']);
   if(isset($text_box)){
	$textAr = explode("\n", $text_box);
	$textAr = str_replace('\'','',$textAr);
	$textAr = str_replace(',','',$textAr);
	$textAr = array_filter($textAr, 'trim');
      foreach ($textAr as $line) {
	echo "$line<br>";
	echo get_embed('youtube', $line);
	echo '<br>';
        }
   } else {
   if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $expensions= array("txt","m3u");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a TXT or M3U file.";
      }
      
      if($file_size > 2097152){
         $errors[]='Max Size is 2 MB';
      }
      if(empty($errors)==true){
	//Hier komt dus het verwerking gedeelte
	$fp = fopen("uploads/".$file_name, 'rb');
	while ( ($line = fgets($fp)) !== false) {
	//echo "$line<br>";
	echo get_embed('youtube', $line);
	echo '<br>';
	}        
	move_uploaded_file($file_tmp,"uploads/".$file_name);
        echo "Success";
	#print_r($_FILES);
      }else{
         print_r($errors);
      }
   }
   }
?>
<html>
   <body>
      
      <form action="" method="POST" enctype="multipart/form-data">
         <input type="file" name="image" />
	<textarea rows="5" cols="80" name="text">
	</textarea>
         <input type="submit"/>
      </form>
      
   </body>
</html>
