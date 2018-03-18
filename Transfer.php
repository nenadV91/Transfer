<?php
require('../wp-load.php');
require __DIR__ . '/vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;


class Transfer {
  public $capsule;

  function __construct() {
    $this->capsule = new Capsule();
  }

  function connectToSource($params) {
    $this->capsule->addConnection([
      'driver'    => $params['driver'] ?: 'mysql',
      'host'      => $params['host'] ?: 'localhost',
      'database'  => $params['database'],
      'username'  => $params['username'],
      'password'  => $params['password'],
      'charset'   => $params['charset'] ?: 'utf8',
      'collation' => $params['collation'] ?: 'utf8_unicode_ci',
      'prefix'    => '',
    ]);

    $this->capsule->setAsGlobal();
    $this->capsule->bootEloquent();
  }

  function getDataFromTable($table) {
    return $this->capsule->table($table)->get();
  }

  function seedTheSource() {
    $faker = Faker\Factory::create();

    for($i = 10; $i >= 0; $i--) {
      $this->capsule->table('posts')->insert([
        'author' => $faker->randomDigit,
        'title' => $faker->words(6, true),
        'content' => $faker->words(100, true) 
      ]);
    }
  }

  function toWordpress($rows, $fields = []) {
    foreach($rows as $row) {
      $queryData = ['post_status' => 'publish', 'post_author' => 1];

      foreach($fields as $field) {
        $value = $row->{$field};
        if($value) $queryData['post_' . $field] = $value;
      }  
      
      wp_insert_post($queryData);
    }
  }
}