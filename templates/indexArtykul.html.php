<!DOCTYPE html>
<html lang="pl-PL">
<meta charset="UTF-8">
<link rel="stylesheet" href="css/bootstrap.min.css" />
<script src="js/angular.min.js"></script>
<script src="js/angular-animate.js"></script>
<!-- plik JavaScript do obsługi aplikacji -->
<script src="js/myApp.js"></script>
<script src="js/myController.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-sanitize.min.js"></script>
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

        <div class="form-group">
    <span class="form-group-btn">
    <button type="submit" class="btn btn-success"  >dodaj</button>
    </span>
</div>
</form>

<!-- tabela z kategoriami -->
<!-- dyrektywa ng-init inicjalizuje tabele -->
<table ng-init='getAll()'>
  <tbody>
  <!-- dyrektywa ng-repeat odpowiada za pętlę -->
  <tr ng-repeat="artykul in artykuly">
    </td>
    <td>

        <span ng-hide="artykul.editMode" ng-bind-html="artykul.tresc"></span>

        <textarea ng-if="artykul.editMode" class="animate-if" class="form-control" ng-model="artykul.tresc"
               ng-show="artykul.editMode"
               rows="10" cols="80" data-ck-editor></textarea>

    </td>


    <td>
        <button ng-click="artykul.editMode = true;"
                ng-hide="artykul.editMode"
                type="submit"
                class="btn btn-xs btn-primary">edytuj</button>
        <button ng-click="artykul.editMode = false; update(artykul)"
                ng-show="artykul.editMode"
                type="submit"
                class="btn btn-xs btn-success">zapisz</button>

    </td>
  </tr>
  </tbody>
</table>

<div ng-hide="msg === 'OK'" class="alert alert-danger" role="alert">{{ msg }}</div>
</div>

</div>
</body>
</html>
