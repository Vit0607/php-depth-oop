<?php

use JasonGrimes\Paginator;

 $this->layout('layout', ['title' => 'Posts']) ?>

<h1>Posts</h1>
<!-- <p>Hello, <?=$this->e($name)?></p> -->

<?php

$itemsPerPage = 3;
$currentPage = $_GET['page'] ?? 1;
$urlPattern = '?page=(:num)';

$paginator = new Paginator(count($totalItemsInView), $itemsPerPage, $currentPage, $urlPattern);

foreach($itemsInView as $item) {
    echo $item['id'] . PHP_EOL . $item['title'] . '<br>';
}

echo $paginator;