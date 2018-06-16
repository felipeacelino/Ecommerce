<?php

use \Hcode\Page;
use \Hcode\Model\Product;
use \Hcode\Model\Category;

$app->get('/', function() {

	$products = Product::listAll();

	$page = new Page();

	$page->setTpl("index", array(
		"products" => Product::checkList($products)
	));
	
});

$app->get('/category/:idcategory', function($idcategory) {

	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	$category = new Category();
	$category->get((int)$idcategory);

	$pagination = $category->getProductsPage($page);

	$pages = array();

	for ($i=1; $i <= $pagination['pages']; $i++) { 
		array_push($pages, array(
			'link' => 'http://localhost/ecommerce/category/'.$category->getidcategory().'?page='.$i,
			'page' => $i
		));
	}

	$page = new Page();

	$page->setTpl("category", array(
		"category" => $category->getValues(),
		"products" => $pagination['data'],
		"pages" => $pages
	));
	
});

$app->get('/products/:desurl', function($desurl) {

	$product = new Product();
	$product->getFromURL($desurl);

	$categories = $product->getCategories();
	$categoriesLink = array();

	foreach ($categories as $value) {
		
		$link = "<a href='http://localhost/ecommerce/category/".$value['idcategory']."'>".$value['descategory']."</a>";

		array_push($categoriesLink, $link);

	}

	$categoriesLink = implode(', ', $categoriesLink);

	$page = new Page();
 
	$page->setTpl("product-detail", array(
		"product" => $product->getValues(),
		"categories" => $categoriesLink
	));
	
});