<?php 
require('Transfer.php');


$transfer = new Transfer();
$transfer->connectToSource([
  'database' => 'postsdb', 
  'username' => 'root',
  'password' => ''
]);


// $transfer->seedTheSource();

$posts = $transfer->getDataFromTable('posts');
$transfer->toWordpress($posts, ['title', 'content', 'author']);

?>
