<!DOCTYPE html>

<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="Stylesheet" href="styl.css" type="text/css" />


</head>
    <body>
<?php
	require_once('./libs/autoload.php');

        use \Config\Database\DBConfig as DB;
        DB::setDBConfig();
        $pdo = DB::getHandle();

try
	{
        $query = "DROP TABLE IF EXISTS `ksiazka`,`kategoria`,`autor`";
        
        $pdo->exec($query);
    
		
		
	}
	catch(PDOException $e)
	{
		echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
	} 

    try
	{
        $query = "CREATE TABLE IF NOT EXISTS `kategoria` 
            ( `id` INT NOT NULL AUTO_INCREMENT, 
             `nazwa` VARCHAR(50) NOT NULL,
             PRIMARY KEY (id))";
        
        $pdo->exec($query);
    
	}
	catch(PDOException $e)
	{
		echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
	}
        try
	{
        $query = "CREATE TABLE IF NOT EXISTS `autor` 
            ( `id` INT NOT NULL AUTO_INCREMENT, 
             `imie` VARCHAR(50) NOT NULL,
             `nazwisko` VARCHAR(50) NOT NULL,
             PRIMARY KEY (id))";
        
        $pdo->exec($query);
    
	}
	catch(PDOException $e)
	{
		echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
	}
        try
	{
        $query = "CREATE TABLE IF NOT EXISTS `ksiazka` 
            ( `id` INT NOT NULL AUTO_INCREMENT, 
             `tytul` VARCHAR(50) NOT NULL,
             `id_autor` INT NOT NULL,
             `rok_wydania` INT NOT NULL,
             `id_kategoria` INT NOT NULL,
             PRIMARY KEY (`id`))";
        
        $pdo->exec($query);
    
	}
    
	catch(PDOException $e)
	{
		echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
	}
    try
	{
        $query = "ALTER TABLE ksiazka ADD FOREIGN KEY(`id_autor`) REFERENCES autor(`id`)
     ON DELETE CASCADE;";
        $pdo->exec($query);
    
	}
	catch(PDOException $e)
	{
		echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
	} 
    try
	{
        $query = "ALTER TABLE ksiazka ADD FOREIGN KEY(`id_kategoria`) REFERENCES kategoria(`id`)
     ON DELETE CASCADE;";
        $pdo->exec($query);
    
	}
	catch(PDOException $e)
	{
		echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
	}
    try
    {
        $autorzy=array();
        $autorzy[]=array('imie'=> 'Dan',
                         'nazwisko'=> 'Brown');
        $autorzy[]=array('imie'=> 'Katarzyna',
                         'nazwisko'=> 'Puzynska');
        $autorzy[]=array('imie'=> 'Michail',
                         'nazwisko'=> 'Bulhakow');
        
         $stmt = $pdo -> prepare('INSERT INTO `autor`(`imie`, `nazwisko`)
    VALUES(:imie, :nazwisko)');
        foreach($autorzy as $autor)
        {
            $stmt -> bindValue(':imie', $autor['imie'], PDO::PARAM_STR);
            $stmt -> bindValue(':nazwisko', $autor['nazwisko'], PDO::PARAM_STR);
            $stmt -> execute();
        }
    }
catch(PDOException $e)
    {
        echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
    }
    try
    {
        $kategorie=array();
        $kategorie[]=array('nazwa'=> 'sensacja');
        $kategorie[]=array('nazwa'=> 'kryminal');
        $kategorie[]=array('nazwa'=> 'obyczaj');
        $kategorie[]=array('nazwa'=> 'fantastyka');
        $kategorie[]=array('nazwa'=> 'romantyk');
        
         $stmt = $pdo -> prepare('INSERT INTO `kategoria`(`nazwa`)
    VALUES(:nazwa)');
        foreach($kategorie as $kategoria)
        {
            $stmt -> bindValue(':nazwa', $kategoria['nazwa'], PDO::PARAM_STR);
            $stmt -> execute();
        }
    }
catch(PDOException $e)
    {
        echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
    }   
        
    try
    {
        $ksiazki=array();
        $ksiazki[]=array('tytul'=> 'Inferno',
                        'id_autor'=> '1',
                        'rok_wydania'=> '2016',
                        'id_kategoria'=> '1');
        $ksiazki[]=array('tytul'=> 'Motylek',
                        'id_autor'=> '2',
                        'rok_wydania'=> '2012',
                        'id_kategoria'=> '2');
        $ksiazki[]=array('tytul'=> 'Mistrz i Malgorzata',
                        'id_autor'=> '3',
                        'rok_wydania'=> '2008',
                        'id_kategoria'=> '3');
        $ksiazki[]=array('tytul'=> 'Kod Da Vinci',
                        'id_autor'=> '1',
                        'rok_wydania'=> '2005',
                        'id_kategoria'=> '1');
        
         $stmt = $pdo -> prepare('INSERT INTO `ksiazka`(`tytul`, `id_autor`,`rok_wydania`,`id_kategoria`)
    VALUES(:tytul, :id_autor, :rok_wydania, :id_kategoria)');
        foreach($ksiazki as $ksiazka)
        {
            $stmt -> bindValue(':tytul', $ksiazka['tytul'], PDO::PARAM_STR);
            $stmt -> bindValue(':id_autor', $ksiazka['id_autor'], PDO::PARAM_STR);
            $stmt -> bindValue(':rok_wydania', $ksiazka['rok_wydania'], PDO::PARAM_STR);
            $stmt -> bindValue(':id_kategoria', $ksiazka['id_kategoria'], PDO::PARAM_STR);
            $stmt -> execute();
        }
    }
catch(PDOException $e)
    {
        echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
    }
        /*
    
try
	{
    $ksiazki = array();
    $ksiazki[] = array('tytul' => 'Inferno',
                      'autor' => 'Dan Brown',
                      'rok_wydania' => '2016',
                      'kategoria' => 'sensacja');
    $ksiazki[] = array('tytul' => 'Motylek',
                      'autor' => 'Katarzyna Puzynska',
                      'rok_wydania' => '2012',
                      'kategoria' => 'kryminal');
    $ksiazki[] = array('tytul' => 'Mistrz i Malgorzata',
                      'autor' => 'Michail Bulhakow',
                      'rok_wydania' => '2008',
                      'kategoria' => 'obyczaj');
    $ksiazki[] = array('tytul' => 'Kod Da Vinci',
                      'autor' => 'Dan Brown',
                      'rok_wydania' => '2005',
                      'kategoria' => 'sensacja');


    $stmt = $pdo -> prepare('INSERT INTO `ksiazka`(`tytul`, `autor`,`rok_wydania`,`kategoria`)
    VALUES(:tytul, :autor, :rok_wydania, :kategoria)');
    foreach($ksiazki as $ksiazka)
    {
        $stmt -> bindValue(':tytul', $ksiazka['tytul'], PDO::PARAM_STR);
        $stmt -> bindValue(':autor', $ksiazka['autor'], PDO::PARAM_STR);
        $stmt -> bindValue(':rok_wydania', $ksiazka['rok_wydania'], PDO::PARAM_STR);
        $stmt -> bindValue(':kategoria', $ksiazka['kategoria'], PDO::PARAM_STR);
        $stmt -> execute();
    }

        
    
	}
catch(PDOException $e)
    {
        echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
    }
    */
echo "<p><a href='index.php'>Przejdź do strony głównej</a></p>";
?>
    </body>
</html>