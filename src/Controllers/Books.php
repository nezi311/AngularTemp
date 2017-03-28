<?php
	namespace Controllers;
	class Books extends Controller {
        
		//zwraca listę kategorii		
		public function index(){
			$view = $this->getView('Books');
            $model = $this->getModel('Books');
			$view->renderJSON($model->getAll());
		}
        public function indexKategoria(){
			$view = $this->getView('Books');
			$model = $this->getModel('Categories');
            $view->renderJSON($model->getAllKat());
            
		}
        public function indexAutor(){
			$view = $this->getView('Books');
			$model = $this->getModel('Authors');
            $view->renderJSON($model->getAllAut());
            
		}
		//usuwa wybraną kategorię
		public function delete($id){
            $view = $this->getView('Books');
            $model = $this->getModel('Books');
            $view->renderJSON($model->delete($id));
		}   
		//aktualizuj 
		public function update() {
            $view = $this->getView('Books');
			$model = $this->getModel('Books');
            $view->renderJSON($model->update($_GET['id'], $_GET['tytul'], $_GET['id_autor'], $_GET['rok_wydania'], $_GET['id_kategoria']));
		}      
		//dodaje do bazy kategorię
		public function insert() {
            $view = $this->getView('Books');
			$model = $this->getModel('Books');
			$view->renderJSON($model->insert($_GET['tytul'], $_GET['id_autor'], $_GET['rok_wydania'], $_GET['id_kategoria']));
		}           
	}
?>