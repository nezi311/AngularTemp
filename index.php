<?php
	//automatyczne ładowanie potrzebnych klas
	require_once('./libs/autoload.php');
	//use Config\Database\DBConfig as DB;
	\Config\Database\DBConfig::setDBConfig();
	//przykład uwzględnia obsługę jednego kontrolera,
	//który wykonuje określone akcje $action
	//i może otrzymywać parametry poprzez zmienną $id
  if(isset($_GET['controller']))
    $controller = $_GET['controller'];
  else
    $controller = 'books';
  if(isset($_GET['action']))
    $action = $_GET['action'];
  else
    $action = 'index';
  if(isset($_GET['id']))
    $id = $_GET['id'];
  else
    $id = null;
  $controller='Controllers\\'.$controller;
  //tworzymy kontroler
  $mycontroller = new $controller;
  //wykonujemy akcję dla kontrolera
  $mycontroller->$action($id);

?>
