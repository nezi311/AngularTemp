<?php
	namespace Views;

	class Books extends View {
			public function index()
			{
				$this->render('indexArtykul');
				return true;
			}
    }
?>
