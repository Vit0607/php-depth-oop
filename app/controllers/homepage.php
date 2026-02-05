<?php

use  App\QueryBuilder;

$db = new QueryBuilder;

$db->delete('posts', 5);