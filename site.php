<?php

use \Hcode\Page;
use \Hcode\Model\Product;
use \Hcode\Model\Category;
use \Hcode\Model\Cart;
use \Hcode\Model\User;
use \Hcode\Model\Address;

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

$app->get('/cart', function() {

	$cart = Cart::getFromSession();

	$page = new Page();

	$page->setTpl("cart", array(
		"cart" => $cart->getValues(),
		"products" => $cart->getProducts(),
		"error" => Cart::getMsgError()
	));
	
});

$app->get('/cart/:idproduct/add', function($idproduct) {

	$product = new Product();
	$product->get((int)$idproduct);
 
	$cart = Cart::getFromSession();

	$qtd = (isset($_GET['qtd']) && $_GET['qtd'] > 1) ? (int)$_GET['qtd'] : 1;

	for ($i=0; $i < $qtd; $i++) { 
		
		$cart->addProduct($product);

	}
	
	header("Location: http://localhost/ecommerce/cart");
	exit;

});

$app->get('/cart/:idproduct/minus', function($idproduct) {

	$product = new Product();
	$product->get((int)$idproduct);

	$cart = Cart::getFromSession();
	$cart->removeProduct($product);
	
	header("Location: http://localhost/ecommerce/cart");
	exit;

});

$app->get('/cart/:idproduct/remove', function($idproduct) {

	$product = new Product();
	$product->get((int)$idproduct);

	$cart = Cart::getFromSession();
	$cart->removeProduct($product, true);
	
	header("Location: http://localhost/ecommerce/cart");
	exit;

});

$app->post('/cart/freight', function() {

	$cart = Cart::getFromSession();

	$cart->setFreight($_POST['zipcode']);

	header("Location: http://localhost/ecommerce/cart");
	exit;

});

$app->get('/checkout', function() {

	User::verifyLogin(false);

	$cart = Cart::getFromSession();

	$address = new Address();

	$page = new Page();
	$page->setTpl("checkout", array(
		"cart" => $cart->getValues(),
		"address" => $address->getValues()
	));

});

$app->get('/login', function() {

	$page = new Page();
	$page->setTpl("login", array(
		"error" => User::getError(),
		"errorRegister" => User::getRegisterError(),
		"registerValues" => (isset($_SESSION['registerValues'])) ? $_SESSION['registerValues'] : array(
			'name' => '',
			'email' => '',
			'phone' => ''
		)
	));

});

$app->post('/login', function() {
	 
	try {

		User::login($_POST['login'], $_POST['password']);

	} catch(Exception $e) {

		User::setError($e->getMessage());

	}
	
	header("Location: http://localhost/ecommerce/checkout");
	exit;

});

$app->get('/logout', function() {

	User::logout();
	
	header("Location: http://localhost/ecommerce/login");

	exit;

});


$app->post('/register', function() {

	$_SESSION['registerValues'] = $_POST;

	if (!isset($_POST['name']) || $_POST['name'] == "") {
		User::setRegisterError("Preencha o seu nome.");
		header("Location: http://localhost/ecommerce/login");
		exit;
	}

	if (!isset($_POST['email']) || $_POST['email'] == "") {
		User::setRegisterError("Preencha o seu e-mail.");
		header("Location: http://localhost/ecommerce/login");
		exit;
	}

	if (!isset($_POST['password']) || $_POST['password'] == "") {
		User::setRegisterError("Preencha a senha.");
		header("Location: http://localhost/ecommerce/login");
		exit;
	}

	if (User::checkLoginExist($_POST['email']) === true) {
		User::setRegisterError("Este endereço de e-mail já está sendo usado por outro usuário.");
		header("Location: http://localhost/ecommerce/login");
		exit;
	}

	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, [
        "cost"=>12
    ]);

	$user = new User();
	$user->setData(array(
		"inadmin" => 0,
		"deslogin" => $_POST['email'],
		"desperson" => $_POST['name'],
		"desemail" => $_POST['email'],
		"despassword" => $password,
		"nrphone" => $_POST['phone']
	));
	$user->save();

	User::login($_POST['email'], $_POST["password"]);

	header("Location: http://localhost/ecommerce/checkout");
	exit;

});

$app->get('/forgot', function() {

	$page = new Page();

	$page->setTpl("forgot");
	
});

$app->post('/forgot', function() {

	$user = User::getForgot($_POST['email'], false);

	header("Location: http://localhost/ecommerce/forgot/sent");
	exit;
	
});

$app->get('/forgot/sent', function() {

	$page = new Page();

	$page->setTpl("forgot-sent");
	
});

$app->get('/forgot/reset', function() {

	$user = User::validForgotDecrypt($_GET['code']);

	$page = new Page();

	$page->setTpl("forgot-reset", array(
		"name" => $user['desperson'],
		"code" => $_GET['code']
	));
	
});

$app->post('/forgot/reset', function() {

	$forgot = User::validForgotDecrypt($_POST['code']);

	User::setForgotUsed($forgot['idrecovery']);

	$user = new User();

	$user->get((int)$forgot['iduser']);

	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, [
        "cost"=>12
    ]);

	$user->setPassword($password);

	$page = new Page();

	$page->setTpl("forgot-reset-success");
	
});