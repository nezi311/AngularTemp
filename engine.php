<?php
	//automatyczne ładowanie potrzebnych klas
	require_once('./libs/autoload.php');
	//use Config\Database\DBConfig as DB;
	\Config\Database\DBConfig::setDBConfig();
	//przykład uwzględnia obsługę jednego kontrolera,
	//który wykonuje określone akcje $action
	//i może otrzymywać parametry poprzez zmienną $id
	if(isset($_GET['action']))
		$action = $_GET['action'];
	else
		$action = 'index';
	if(isset($_GET['id']))
		$id = $_GET['id'];
	else	
		$id = null;
	
	//tworzymy kontroler
	$controller = new Controllers\Books();
	//wykonujemy akcję dla kontrolera
	$controller->$action($id);

?>


