<!DOCTYPE html>
<html lang="pl-PL">
<meta charset="UTF-8">
<link rel="stylesheet" href="css/bootstrap.min.css" />
<script src="js/angular.min.js"></script>
<script src="js/angular-animate.js"></script>
<!-- plik JavaScript do obsługi aplikacji -->
<script src="js/myApp.js"></script>
<script src="js/myController.js"></script>
<body>

<div class="container">
<h1>AngularJS</h1>
<!-- dyrektywa ng-app definiuje aplikację AngularJS -->
<!-- dyrektywa ng-controller określa kontroler dla tego elemntu HTML -->
<div ng-app="myApp" ng-controller="myController" >

<!-- formularz dodawania nowej kategorii -->
<form class="form-inline" ng-submit="insert()">
<div class="form-group">
    <label for="tytul">Tytuł:</label>
    <input ng-model="newTytul"
           type="text"
           class="form-control"
           placeholder="Tytuł"
           required>
</div>

    <div  ng-init='getAllAut()' class="form-group">
    <label for="autor">Autor:</label>
        <select class="form-control"  ng-model="newAutor">
   <option ng-repeat="autor in authors"  value="{{autor.id}}">{{autor.imie}} {{autor.nazwisko}}</option>
    </select>
</div>
<div class="form-group">
    <label for="Rok wydania">Rok wydania:</label>
    <input ng-model="newRok"
           type="text"
           class="form-control"
           placeholder="Rok wydania"
           required>
</div>
<div  ng-init='getAllKat()' class="form-group">
    <label for="kategoria">Kategoria:</label>
        <select class="form-control"  ng-model="newKategoria">
   <option ng-repeat="kategoria in categories"  value="{{kategoria.id}}">{{kategoria.nazwa}}</option>
    </select>
</div>
        <div class="form-group">
    <span class="form-group-btn">
    <button type="submit" class="btn btn-success"  >dodaj</button>
    </span>
</div>
</form>

<!-- tabela z kategoriami -->
<!-- dyrektywa ng-init inicjalizuje tabele -->
<table ng-init='getAll()' class="table table-striped">
  <thead>
  <tr>
     <th ng-click="sortType = 'id'; sortReverse = !sortReverse;"
         style="width: 10%">Id
     <!-- dyrektywa ng-show nakłada warunek na pokazanie elementu -->
     <span ng-show="sortType === 'id' && !sortReverse"
           class="glyphicon glyphicon-menu-down"></span>
     <span ng-show="sortType === 'id' && sortReverse"
           class="glyphicon glyphicon-menu-up"></span>
     </th>
     <th ng-click="sortType = 'tytul'; sortReverse = !sortReverse;"
         style="width: 20%">Tytuł
     <span ng-show="sortType === 'tytul' && !sortReverse"
           class="glyphicon glyphicon-menu-down"></span>
     <span ng-show="sortType === 'tytul' && sortReverse"
           class="glyphicon glyphicon-menu-up"></span>
     </th>
     <th ng-click="sortType = 'imie'; sortReverse = !sortReverse;"
         style="width: 20%">Autor
     <span ng-show="sortType === 'imie' && !sortReverse"
           class="glyphicon glyphicon-menu-down"></span>
     <span ng-show="sortType === 'imie' && sortReverse"
           class="glyphicon glyphicon-menu-up"></span>
     </th>
      <th ng-click="sortType = 'rok_wydania'; sortReverse = !sortReverse;"
         style="width: 20%">Rok wydania
     <span ng-show="sortType === 'rok_wydania' && !sortReverse"
           class="glyphicon glyphicon-menu-down"></span>
     <span ng-show="sortType === 'rok_wydania' && sortReverse"
           class="glyphicon glyphicon-menu-up"></span>
     </th>angular.min.js
      <th ng-click="sortType = 'nazwa'; sortReverse = !sortReverse;"
         style="width: 20%">Kategoria
     <span ng-show="sortType === 'nazwa' && !sortReverse"
           class="glyphicon glyphicon-menu-down"></span>
     <span ng-show="sortType === 'nazwa' && sortReverse"
           class="glyphicon glyphicon-menu-up"></span>
     </th>
     <th style="width: 30%">Operacje</th>
  </tr>
  </thead>
  <tbody>
  <!-- dyrektywa ng-repeat odpowiada za pętlę -->
  <tr ng-repeat="book in books | orderBy:sortType:sortReverse">
    <td>
        {{ book.id }}
    </td>
    <td>
        <span ng-hide="book.editMode">{{ book.tytul }}</span>
        <input class="form-control" ng-model="book.tytul"
               ng-show="book.editMode"
               type="text" />
    </td>
    <td>
        <span ng-hide="book.editMode">{{ book.imie }} {{ book.nazwisko }}</span>
        <select class="form-control" ng-show="book.editMode" ng-model="book.id_autor" >
           <option ng-repeat="autor in authors"
                value={{autor.id}}>{{autor.imie}} {{autor.nazwisko}}</option>
           </select>
    </td>
    <td>
        <span ng-hide="book.editMode">{{ book.rok_wydania }}</span>
        <input class="form-control" ng-model="book.rok_wydania"
               ng-show="book.editMode"
               type="text" />
    </td>
   <td>
        <span ng-hide="book.editMode">{{ book.nazwa }}</span>
           <select class="form-control" ng-show="book.editMode" ng-model="book.id_kategoria" >
           <option ng-repeat="kategoria in categories"
                value={{kategoria.id}}>{{kategoria.nazwa}}</option>
           </select>
    </td>
    <td>
        <button ng-click="book.editMode = true;"
                ng-hide="book.editMode"
                type="submit"
                class="btn btn-xs btn-primary">edytuj</button>
        <button ng-click="book.editMode = false; update(book)"
                ng-show="book.editMode"
                type="submit"
                class="btn btn-xs btn-success">zapisz</button>
        
        <button ng-click="delete(book)"
                type="submit"
                class="btn btn-xs btn-danger">usuń</button>
    </td>
  </tr>
  </tbody>
</table>

<div ng-hide="msg === 'OK'" class="alert alert-danger" role="alert">{{ msg }}</div>
</div>

</div>
</body>
</html>
