<?php
	namespace Views;
	
	abstract class View {

		//załadowanie modelu
		public function getModel($name){
			$name = 'Models\\'.$name;
			return new $name();
		}
		
		//załadowanie i zrenderowanie szablonu
		public function render($name) {
			$path='templates'.DIRECTORY_SEPARATOR;
			$path.=$name.'.html.php';
			try {
				if(is_file($path)) {
					require $path;
				} else {
					throw new Exception('Nie można załączyć szablonu '.$name.' z: '.$path);
				}
			}
			catch(Exception $e) {
				echo $e->getMessage().'<br />
					Plik: '.$e->getFile().'<br />
					Linia: '.$e->getLine().'<br />
					Ślad: '.$e->getTraceAsString();
				exit;
			}
		}
        
        //zrenderowanie danych w fromacie JSON
        public function renderJSON($data) {
            //header('Content-Type: application/json');
            echo json_encode($data);
            exit;
        }        

		public function set($name, $value) {
			$this->$name=$value;
		}

		public function get($name) {
			return $this->$name;
		}		
		
		
	}



?>