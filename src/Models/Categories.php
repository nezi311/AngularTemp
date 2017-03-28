<?php
	namespace Models;
	use \PDO;
	class Categories extends Model {
		//model zwraca tablicę wszystkich kategorii 
		public function getAllKat(){
            $data = array();
			try
			{ 
                $categories = array();
				$stmt = $this->pdo->query('SELECT * FROM `kategoria`');
				
                $categories = $stmt->fetchAll();
				$stmt->closeCursor();
                if($categories && !empty($categories))
				{
				    $data['categories'] = $categories;
				}
                else
				{
					$data['categories'] = array();
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