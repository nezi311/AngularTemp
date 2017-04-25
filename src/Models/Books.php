<?php
	namespace Models;
	use \PDO;
	class Books extends Model {
		//model zwraca tablicę wszystkich kategorii
		public function getAll(){
            $data = array();
			try
			{
                $artykuly = array();
				$stmt = $this->pdo->query('SELECT * FROM Artykul');
				/*foreach ($stmt as $row) {
					$books[]=$row;
				}
				$stmt->closeCursor();
				$data['books'] = $books;
                $data['msg'] = 'OK'; */
                $artykuly = $stmt->fetchAll();
				$stmt->closeCursor();
                if($artykuly && !empty($artykuly))
				{
				    $data['artykuly'] = $artykuly;
				}
                else
				{
					$data['artykuly'] = array();
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
		public function update($id, $tresc) {
            $data = array();
            if($id === NULL || $tresc === NULL)
            {
                $data['msg'] = 'Nieokreślone id lub nazwa!';
                return $data;
            }
			try
			{
								var_dump($id,$tresc);
                $stmt = $this->pdo->prepare('UPDATE `artykul` SET `tresc` = :Tresc WHERE `id` = :Id');
                $stmt->bindValue(':Id', $id, PDO::PARAM_INT);
                $stmt->bindValue(':Tresc', $tresc, PDO::PARAM_STR);
								$result = $stmt->execute();
                $rows = $stmt->rowCount();
								$stmt->closeCursor();

                if ($result)
                {
                	$artykul = array();
									$stmt = $this->pdo->prepare('SELECT * FROM `artykul` WHERE `id`= :id');
                	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
									$result = $stmt->execute();
									$artykul = $stmt->fetchAll();
									$stmt->closeCursor();
										//czy istnieje kategoria o padanym id
										if($result && $artykul && !empty($artykul))
						        {
											$data['artykul'] = $artykul[0];
						          $data['msg'] = 'OK';
						        }
										else
						        {
											$data['artykul'] = array();
						          $data['msg'] = "Brak artykulu o id=$id";
						        }
            		}
                $data['msg'] = $result ? 'OK' : "Nie znaleziono artykulu o id = $id!";
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
