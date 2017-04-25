// dodanie kontrolera do modułu
// argument $scope pełni rolę łacznika pomiędzy widokiem HTML, a kontrolerem JavaScript
// argument $http to usługa AngularJS pozwalająca uzyskiwać połączenie z zdalnym serwerem
// $ oznacz zmienne z przestrzeni AngularJS
app.controller('myController', function($scope, $http)
{



    //zmienna komunikatów błędów
    $scope.msg = '';
    //wyświetlanie wszytskich kategorii

    $scope.getAll = function ()
    {
        $scope.sortType = 'id';
        $scope.sortReverse = false;
        $http.get("index.php?action=getAll")
        .then(
                // sukces
                function (response)
                {
                    // odczyt komunikatów
                    $scope.msg = response.data.msg;
                    // odczyt danych
                    $scope.artykuly = response.data.artykuly;
                    // domyślna wartość trybu edit
                    for(artykul of $scope.artykuly)
                    {
                      artykul.editMode = false;
                      console.log($scope.artykuly);
                      //artykul.tresc = $sce.trustAsHtml(artykul.tresc);
                    }

                },
                // błąd
                function (response)
                {
                    // ustawienie komunikatu
                    $scope.msg = response.statusText;
                }
        );
    }
    //usuwanie wybranej kategorii
    //aktualizacja wybranej kategorii
    $scope.update = function (artykul)
    {
        index = $scope.artykuly.indexOf(artykul);
        $http.get("index.php",
               {params: {'action': 'update',
                         id: $scope.artykuly[index].id,
                         tresc: $scope.artykuly[index].tresc,
                        }})
             .then(
                // sukces
                function (response)
                {
                    $scope.msg = response.data.msg;
                    $scope.artykuly[index] = response.data.artykul;
                },
                // błąd
                function (response)
                {
                    //kasujemy poprzednie komunikaty
                    $scope.msg = response.statusText;
                }
             );
    }
    //dodanie nowej książki
    $scope.insert = function () {
       $http.get("engine.php?action=insert",
               {params: {tytul: $scope.newTytul,
                         id_autor: $scope.newAutor,
                         rok_wydania: $scope.newRok,
                         id_kategoria: $scope.newKategoria
                        }})
             .then(
                // sukces
                function (response) {
                   $scope.msg = response.data.msg;
                   if($scope.msg === 'OK' && response.data.book !== null)
                       $scope.books.push(response.data.book);
                },
                // błąd
                function (response) {
                    //kasujemy poprzednie komunikaty
                    $scope.msg = response.statusText;
                }
        );
    }
});
