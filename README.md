
### Installing

Download the repository and place it inside root directory of your wordpress folder.
cd inside repository and install dependencies with

```
composer install
```

```php
require('Transfer.php');

// Create new instance and connect to source database
$transfer = new Transfer();
$transfer->connectToSource([
  'database' => 'source_database', 
  'username' => 'source_username',
  'password' => 'source_password'
]);

// Optional source database seed
// $transfer->seedTheSource();

// Get data from table named posts in source database
$posts = $transfer->getDataFromTable('posts');

// Select columns from source table and add that data to wordpress posts table
// It will use wp_insert_post() method to insert data in wordpress table
$transfer->toWordpress($posts, ['title', 'content', 'author']);

```