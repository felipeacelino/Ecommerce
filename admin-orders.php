<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Order;
use \Hcode\Model\OrderStatus;

$app->get('/admin/orders/:idorder/status', function($idorder) {

    User::verifyLogin();

    $order = new Order();
    $order->get((int)$idorder);

    $page = new PageAdmin();
	$page->setTpl("order-status", array(
		'order' => $order->getValues(),
		'status' => OrderStatus::listAll(),
		'msgError' => Order::getError(),
		'msgSuccess' => Order::getSuccess()
	));

});

$app->post('/admin/orders/:idorder/status', function($idorder) {

    User::verifyLogin();

    if (!isset($_POST['idstatus']) || !(int)$_POST['idstatus'] > 0) {
        Order::setError("Informe o status atual.");
        header("Location: http://localhost/ecommerce/admin/orders/".$idorder."/status");
	    exit;
    }

    $order = new Order();
    $order->get((int)$idorder);
    $order->setidstatus((int)$_POST['idstatus']);
    $order->save();

    Order::setSuccess("Status atualizado com sucesso.");
    
    header("Location: http://localhost/ecommerce/admin/orders/".$idorder."/status");
    exit;

});

$app->get('/admin/orders/:idorder/delete', function($idorder) {

    User::verifyLogin();

    $order = new Order();
    $order->get((int)$idorder);
    $order->delete();

    header("Location: http://localhost/ecommerce/admin/orders");
	exit;
	
});

$app->get('/admin/orders/:idorder', function($idorder) {

    User::verifyLogin();

    $order = new Order();
    $order->get((int)$idorder);

    $cart = $order->getCart();

    $page = new PageAdmin();
	$page->setTpl("order", array(
		'order' => $order->getValues(),
		'cart' => $cart->getValues(),
		'products' => $cart->getProducts()
	));
	
});

$app->get('/admin/orders', function() {

    User::verifyLogin();

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	if ($search != "") {
	
		$pagination = Order::getPageSearch($search, $page);

	} else {

		$pagination = Order::getPage($page);

	}

	$pages = array();

	for ($x=1; $x<=$pagination['pages']; $x++) {
		array_push($pages, array(
			"href" => "http://localhost/ecommerce/admin/orders?".http_build_query(array(
				"page" => $x,
				"search" => $search
			)),
			"text" => $x
		));
	}

	$page = new PageAdmin();
	$page->setTpl("orders", array(
		'orders' => $pagination['data'],
		'search' => $search,
		'pages' => $pages
	));

});

