<?php
	namespace Models;
	use \PDO;
	class Books extends Model {
		//model zwraca tablicę wszystkich kategorii 
		public function getAll(){
            $data = array();
			try
			{ 
                $books = array();
				$stmt = $this->pdo->query('SELECT ksiazka.*, imie, nazwisko, nazwa
FROM `ksiazka`
INNER JOIN `kategoria`
ON ksiazka.id_kategoria=kategoria.id
INNER JOIN `autor`
ON ksiazka.id_autor=autor.id');
				/*foreach ($stmt as $row) {
					$books[]=$row;
				}
				$stmt->closeCursor();
				$data['books'] = $books;
                $data['msg'] = 'OK'; */
                $books = $stmt->fetchAll();
				$stmt->closeCursor();
                if($books && !empty($books))
				{
				    $data['books'] = $books;
				}
                else
				{
					$data['books'] = array();
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
		//model usuwa wybraną kategorię
		public function delete($id){
            $data = array();
            if($id === NULL)
            {
                $data['msg'] = 'Nieokreślone id!';    
                return $data;
            }            
			try
			{		  
				$stmt = $this->pdo->prepare('DELETE FROM `ksiazka` WHERE `id`=:id');
				$stmt->bindValue(':id', $id, PDO::PARAM_INT); 
				$result = $stmt->execute(); 
                $rows = $stmt->rowCount();
				$stmt->closeCursor();
                $data['msg'] = ($result && $rows > 0) ? 'OK' : "Nie znaleziono książki o id = $id!";
			}
			catch(\PDOException $e)
			{
			  $data['msg'] = 'Połączenie z bazą nie powidoło się!';
			}	
            return $data;
		}        
		//model aktualizuje wybraną kategorię
		public function update($id, $tytul, $id_autor, $rok_wydania, $id_kategoria) {
            $data = array();
            if($id === NULL || $tytul === NULL)
            {
                $data['msg'] = 'Nieokreślone id lub nazwa!';    
                return $data;
            }            
			try
			{		  
                $stmt = $this->pdo->prepare('UPDATE `ksiazka` SET tytul = :tytul, id_autor = :id_autor, rok_wydania = :rok_wydania, id_kategoria = :id_kategoria WHERE `id` = :id');
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->bindValue(':tytul', $tytul, PDO::PARAM_STR); 
                $stmt->bindValue(':id_autor', $id_autor, PDO::PARAM_INT);
                $stmt->bindValue(':rok_wydania', $rok_wydania, PDO::PARAM_INT);
                $stmt->bindValue(':id_kategoria', $id_kategoria, PDO::PARAM_INT);
				$result = $stmt->execute(); 
                $rows = $stmt->rowCount();
				$stmt->closeCursor();
                
                if ($result)
                {
                $books = array();
				$stmt = $this->pdo->prepare('SELECT ksiazka.*, imie, nazwisko, nazwa
FROM `ksiazka`
INNER JOIN `kategoria`
ON ksiazka.id_kategoria=kategoria.id
INNER JOIN `autor`
ON ksiazka.id_autor=autor.id
WHERE ksiazka.id= :id');
                
                $stmt->bindValue(':id', $id, PDO::PARAM_INT); 
				$result = $stmt->execute(); 
				$book = $stmt->fetchAll();				
				$stmt->closeCursor();
				//czy istnieje kategoria o padanym id
				if($result && $book && !empty($book))
                {
					$data['book'] = $book[0];
                    $data['msg'] = 'OK';
                }
				else
                {
					$data['book'] = array();
                    $data['msg'] = "Brak kategorii o id=$id";
                }
            }
                $data['msg'] = $result ? 'OK' : "Nie znaleziono kategorii o id = $id!";
			}
			catch(\PDOException $e)
			{
                $data['msg'] = 'Połączenie z bazą nie powidoło się!';
			}	
            return $data;
		}  
		//model dodaje wybraną kategorię
		public function insert($tytul1, $id_autor1, $rok_wydania1, $id_kategoria1) {
            $data = array();
            if($tytul1 === NULL)
            {         
                $data['msg'] = 'Nieokreślona nazwa!';    
                return $data;
            }            
			try
			{		  
				$stmt = $this->pdo->prepare('INSERT INTO `ksiazka` (`tytul`,`id_autor`,`rok_wydania`,`id_kategoria`) 
                    VALUES (:tytul, :autor, :rok_wydania, :kategoria)');
                $stmt->bindValue(':tytul', $tytul1, PDO::PARAM_STR); 
                $stmt->bindValue(':autor', $id_autor1, PDO::PARAM_INT);
                $stmt->bindValue(':rok_wydania', $rok_wydania1, PDO::PARAM_INT);
                $stmt->bindValue(':kategoria', $id_kategoria1, PDO::PARAM_INT);
				$result = $stmt->execute(); 
				if($result)
				{
					$lastId = $this->pdo->lastInsertId();
				    $data = $this->getOne($lastId);				
				}
				else
					$data['msg'] = 'Wstawienie nie powiodło się!';
				$stmt->closeCursor();
			}
			catch(\PDOException $e)
			{
                $data['msg'] = 'Połączenie z bazą nie powidoło się!';
			}	
            return $data;
		}  
		//model zwraca wybraną kategorię
		public function getOne($id){
            $data = array();
            if($id === NULL)
            {
                $data['msg'] = 'Nieokreślone id!';    
                return $data;
            }              
			try
			{		  
				$stmt = $this->pdo->prepare('SELECT ksiazka.*, kategoria.id AS Idkategoria, nazwa, autor.id AS Idautor, imie, nazwisko  FROM `ksiazka`
INNER JOIN `autor`
ON autor.id=ksiazka.id_autor
INNER JOIN `kategoria`
ON kategoria.id=ksiazka.id_kategoria
WHERE ksiazka.id=:id');
				$stmt->bindValue(':id', $id, PDO::PARAM_INT); 
				$result = $stmt->execute(); 
				$book = $stmt->fetchAll();				
				$stmt->closeCursor();
				//czy istnieje kategoria o padanym id
				if($result && $book && !empty($book))
                {
					$data['book'] = $book[0];
                    $data['msg'] = 'OK';
                }
				else
                {
					$data['book'] = array();
                    $data['msg'] = "Brak kategorii o id=$id";
                }
			}
			catch(\PDOException $e)
			{
                $data['msg'] = 'Połączenie z bazą nie powidoło się!';
			}	
            return $data;
		}	
	}
?>