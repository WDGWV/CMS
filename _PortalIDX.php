<?php
@session_start();

include './data/include/loader.php';

$parser = new WDGWV\General\templateParser(true);
$parser->setTemplate('portal', 'html', '/data/template/portal/');
$parser->setParameter('{ITEM:', '}');

$parser->setMenuContents(array(
	"home" => "/",
	"customer" => array(
		"list" => "/customer/list",
		"create" => "/customer/create",
		"delete" => "/customer/delete",
	),
	"client" => array(
		"list" => "/client/list",
		"create" => "/client/create",
		"delete" => "/client/delete",
	),
	"invoice" => array(
		"list" => "/invoice/list",
		"create" => "/invoice/create",
		"delete" => "/invoice/delete",
	),
	"purchase order" => array(
		"list" => "/purchaseorder/list",
		"create" => "/purchaseorder/create",
		"delete" => "/purchaseorder/delete",
	),
	"personell" => array(
		"list" => "/personell/list",
		"create" => "/personell/create",
		"delete" => "/personell/delete",
	),
	"about" => "/about",
));

$parser->bindParameter('BUSINESS_NAME',
	isset($_SESSION['BUSINESS_NAME']) ? $_SESSION['BUSINESS_NAME'] : 'WDGWV'
);

$parser->bindParameter('page', "ABCDEF");

$parser->bindParameter('post', array(
	array(
		"title" => "{$_SERVER['REQUEST_URI']}",
		"content" => "Testing it out...",
		"date" => null,
		"comments" => null,
		"shares" => null,
		"keywords" => null,
	),
	array(
		"title" => "Ali B",
		"content" => "Testing it out...",
		"date" => @date("d-m-Y H:i"),
		"comments" => "0",
		"shares" => "0",
		"keywords" => "Thank You,Rapper,Gehuwd",
	),
	array(
		"title" => "Bert S",
		"content" => "Testing it out...",
		"date" => @date("d-m-Y H:i"),
		"comments" => "0",
		"shares" => "0",
		"keywords" => "Thank You,Sesamstraat,Hond",
	),
	array(
		"title" => "Ernie S",
		"content" => "Testing it out...",
		"date" => @date("d-m-Y H:i"),
		"comments" => "0",
		"shares" => "0",
		"keywords" => "Thank You,Sesamstraat,Muis",
	),
	array(
		"title" => "Pino S",
		"content" => "Testing it out...",
		"date" => @date("d-m-Y H:i"),
		"comments" => "0",
		"shares" => "0",
		"keywords" => "Thank You,Sesamstraat,Vogel",
	),
));

$parser->bindParameter('year', @date('Y'));
$parser->display();
?>