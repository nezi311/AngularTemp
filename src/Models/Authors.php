<?php
	namespace Models;
	use \PDO;
	class Authors extends Model {
		//model zwraca tablicę wszystkich kategorii 
		public function getAllAut(){
            $data = array();
			try
			{ 
                $authors = array();
				$stmt = $this->pdo->query('SELECT id, imie, nazwisko FROM `autor`');
                $authors = $stmt->fetchAll();
				$stmt->closeCursor();
                if($authors && !empty($authors))
				{
				    $data['authors'] = $authors;
				}
                else
				{
					$data['authors'] = array();
                    //$data['msg'] = 'Brak kategorii do wyświetlenia';	
				}
				$data['msg'] = 'OK';
			}
			catch(\PDOException $e)
			{
                $data['msg'] = 'Połączenie z bazą nie powidoło się!';
			}	
            return $data;
		}
	}
?>