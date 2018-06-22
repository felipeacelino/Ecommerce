<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app->get('/admin/users/:iduser/password', function($iduser) {

	User::verifyLogin();

	$user = new User();
	$user->get((int)$iduser);

	$page = new PageAdmin();
	$page->setTpl("users-password", array(
		"user" => $user->getValues(),
		"msgError" => User::getError(),
		"msgSuccess" => User::getSuccess()
	));

});

$app->post('/admin/users/:iduser/password', function($iduser) {

	User::verifyLogin();

	if (!isset($_POST['despassword']) || $_POST['despassword'] == "") {
		User::setError("Digite a nova senha.");
		header("Location: http://localhost/ecommerce/admin/users/".$iduser."/password");
		exit;
	}

	if (!isset($_POST['despassword-confirm']) || $_POST['despassword-confirm'] == "") {
		User::setError("Confirme a nova senha.");
		header("Location: http://localhost/ecommerce/admin/users/".$iduser."/password");
		exit;
	}

	if ($_POST['despassword'] !== $_POST['despassword-confirm']) {
		User::setError("As senhas informadas são diferentes.");
		header("Location: http://localhost/ecommerce/admin/users/".$iduser."/password");
		exit;
	}

	$user = new User();
	$user->get((int)$iduser);
	$user->setPassword($_POST['despassword']);

	User::setSuccess("Senha alterada com sucesso.");
	header("Location: http://localhost/ecommerce/admin/users/".$iduser."/password");
	exit;

});

$app->get('/admin/users', function() {

	User::verifyLogin();

	$search = (isset($_GET['search'])) ? $_GET['search'] : "";
	$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

	if ($search != "") {
	
		$pagination = User::getPageSearch($search, $page);

	} else {

		$pagination = User::getPage($page);

	}

	$pages = array();

	for ($x=1; $x<=$pagination['pages']; $x++) {
		array_push($pages, array(
			"href" => "http://localhost/ecommerce/admin/users?".http_build_query(array(
				"page" => $x,
				"search" => $search
			)),
			"text" => $x
		));
	}

	$page = new PageAdmin();
	$page->setTpl("users", array(
		'users' => $pagination['data'],
		'search' => $search,
		'pages' => $pages
	));

});

$app->get('/admin/users/create', function() {

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-create");

});

$app->get('/admin/users/:iduser/delete', function($iduser) {

	User::verifyLogin();

	$user = new User();
	$user->get((int)$iduser);
	$user->delete();

	header("Location: http://localhost/ecommerce/admin/users");
	exit;

});

$app->get('/admin/users/:iduser', function($iduser) {

	User::verifyLogin();

	$user = new User();
	$user->get((int)$iduser);

	$page = new PageAdmin();

	$page->setTpl("users-update", array(
		"user" => $user->getValues()
	));

});

$app->post('/admin/users/create', function() {

	User::verifyLogin();

	$_POST['inadmin'] = (isset($_POST['inadmin'])) ? 1 : 0;

	$user = new User();
	$user->setData($_POST);
	$user->save();

	header("Location: http://localhost/ecommerce/admin/users");
	exit;

});

$app->post('/admin/users/:iduser', function($iduser) {

	User::verifyLogin();

	$_POST['inadmin'] = (isset($_POST['inadmin'])) ? 1 : 0;

	$user = new User();
	$user->get((int)$iduser);
	$user->setData($_POST);
	$user->update();

	header("Location: http://localhost/ecommerce/admin/users");
	exit;

});