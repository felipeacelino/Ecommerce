<?php

use \Hcode\Page;
use \Hcode\Model\Product;

$app->get('/', function() {

	$products = Product::listAll();

	$page = new Page();

	$page->setTpl("index", array(
		"products" => Product::checkList($products)
	));
	
});

$app->get('/category/:idcategory', function($idcategory) {

	User::verifyLogin();

	$category = new Category();
	$category->get((int)$idcategory);

	$page = new Page();

	$page->setTpl("category", array(
		"category" => $category->getValues(),
		"products" => array()
	));
	
});