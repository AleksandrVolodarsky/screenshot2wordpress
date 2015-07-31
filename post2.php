<?php 
 
require_once("ixr.php"); 
$client->debug = true; //Set it to false in Production Environment 
 
$title=$_POST["title"]; // $title variable will insert your blog title 
$body=$_POST["body"]; // $body will insert your blog content (article content) 
$username = $_POST["user"];//postnikov@gmail.com"; 
$password = $_POST["password"]; 


  //define('UPLOAD_DIR', '');
  $img = $_POST['img'];
  $img = str_replace('data:image/png;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $data = base64_decode($img);
  $file = "images/" . uniqid() . '.png';
  $success = file_put_contents($file, $data);

  $body = $body. "<br><br><img src='/rpc/".$file."'>";

$category=""; // Comma seperated pre existing categories. Ensure that these categories exists in your blog. 
$keywords=""; 
$customfields=array(); //'key'=>'Author-bio', 'value'=>'Autor Bio Here'// Insert your custom values like this in Key, Value format 
 
$title = htmlentities($title,ENT_NOQUOTES,$encoding); 
$keywords = htmlentities($keywords,ENT_NOQUOTES,$encoding); 
 
$content = array( 
                 'title'=>$title, 
                 'description'=>$body, 
                 'mt_allow_comments'=>0, // 1 to allow comments 
                 'mt_allow_pings'=>0, // 1 to allow trackbacks 
                 'post_type'=>'post', 
                 'mt_keywords'=>$keywords, 
                 'categories'=>array($category), 
                 'custom_fields' => array($customfields) 
              ); 
 
// Create the client object 
$client = new IXR_Client('http://codingninjas.co/xmlrpc.php');

$params = array(0,$username,$password,$content,true); // Last parameter is 'true' which means post immediately, to save as draft set it as 'false' 
 
// Run a query for PHP 
if (!$client->query('metaWeblog.newPost', $params)) { 
        die('Something went wrong - '.$client->getErrorCode().' : '.$client->getErrorMessage()); 
   } else { echo "Article Posted Successfully"; } 
   ?>