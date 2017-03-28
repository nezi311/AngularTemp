// dodanie kontrolera do modułu
// argument $scope pełni rolę łacznika pomiędzy widokiem HTML, a kontrolerem JavaScript
// argument $http to usługa AngularJS pozwalająca uzyskiwać połączenie z zdalnym serwerem
// $ oznacz zmienne z przestrzeni AngularJS
app.controller('myController', function($scope, $http)
{
    //zmienna komunikatów błędów
    $scope.msg = '';
    //wyświetlanie wszytskich kategorii
    $scope.getAllAut = function ()
    {
        $scope.sortType = 'id';
        $scope.sortReverse = false;
        $http.get("engine.php?action=indexAutor")
        .then(
                // sukces
                function (response)
                {
                    // odczyt komunikatów
                    $scope.msg = response.data.msg;
                    // odczyt danych

                    $scope.authors = response.data.authors;

                },
                // błąd
                function (response)
                {
                    // ustawienie komunikatu
                    $scope.msg = response.statusText;
                }
      );
    }
    $scope.getAllKat = function ()
    {
        $scope.sortType = 'id';
        $scope.sortReverse = false;
        $http.get("engine.php?action=indexKategoria")
        .then(
                // sukces
                function (response)
                {
                    // odczyt komunikatów
                    $scope.msg = response.data.msg;
                    // odczyt danych
                    $scope.categories = response.data.categories;
                },
                // błąd
                function (response)
                {
                    // ustawienie komunikatu
                    $scope.msg = response.statusText;
                }
        );
    }
    $scope.getAll = function ()
    {
        $scope.sortType = 'id';
        $scope.sortReverse = false;
        $http.get("engine.php?action=index")
        .then(
                // sukces
                function (response)
                {
                    // odczyt komunikatów
                    $scope.msg = response.data.msg;
                    // odczyt danych
                    $scope.books = response.data.books;
                    // domyślna wartość trybu edit
                    for(book of $scope.books)
                        book.editMode = false;
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
    $scope.delete = function (book)
    {
        index = $scope.books.indexOf(book);
        $http.get("engine.php",{params: {'action': 'delete', id: $scope.books[index].id}})
        .then(
                // sukces
                function (response)
                {
                    //kasujemy poprzednie komunikaty
                    $scope.msg = response.data.msg;
                    //usuwamy po stronie klienta
                    if($scope.msg === 'OK')
                        $scope.books.splice(index,1);


                },
                // błąd
                function (response)
                {
                    //kasujemy poprzednie komunikaty
                    $scope.msg = response.statusText;
                }
      );
    }
    //aktualizacja wybranej kategorii
    $scope.update = function (book)
    {
        index = $scope.books.indexOf(book);
        $http.get("engine.php",
               {params: {'action': 'update',
                         id: $scope.books[index].id,
                         tytul: $scope.books[index].tytul,
                         id_autor:$scope.books[index].id_autor,
                         rok_wydania: $scope.books[index].rok_wydania,
                         id_kategoria:$scope.books[index].id_kategoria
                        }})
             .then(
                // sukces
                function (response)
                {
                    $scope.msg = response.data.msg;
                    $scope.books[index] = response.data.book;
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
