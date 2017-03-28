<?php
	/*
	Automatyczne ładowanie klas
	*/
	function __autoload($className)
	{
		//wszystkie klasy znadują się w katalogu src, który  
		//nie jest uwzględniany w przestrzeni nazw
		$path = 'src'.DIRECTORY_SEPARATOR. str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
		//echo $path.'<br>';		
		try {
			if(is_file($path)) {
				require_once($path);
			} else {
				throw new Exception('Nie można załadować '.$className.' z: '.$path);
			}
		}
		catch(Exception $e) {
			//echo $e->getMessage().'<br />
			//	Plik: '.$e->getFile().'<br />
			//	Linia: '.$e->getLine().'<br />
			//	Ślad: '.$e->getTraceAsString();
			exit;
		}	
	}
?>