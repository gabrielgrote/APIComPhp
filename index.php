<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title>Consulta de livros e series de TV</title>
</head>
<body>
    <form id='formLeft' action='index.php' method='post'>
    Titulo do livro: <input type='text' name='bookTitle'>
    <input type='submit' value='Pesquisar'>
    </form>

    <form id='formCenter' action='index.php' method='post'>
    Autor do livro: <input type='text' name='bookAuthor'>
    <input type='submit' value='Pesquisar'>
    </form>

    <form id='formRight' action='index.php' method='post'>
    Serie a pesquisar: <input type='text' name='tvShow'>
    <input type='submit' value='Pesquisar'>
    </form>
    
    <div id='left'>
    <?php
    if ($_POST['bookTitle']!=null){
        $title = $_POST['bookTitle'];
        $bookTitle = $title;
        for ($i=0;$i<strlen($title);$i++){
            if ($title[$i] == ' '){
                $title[$i] = '+';
            }
        }
        $url = 'http://openlibrary.org/search.json?title='.$title;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $res = json_decode(curl_exec($curl));

        $bookAuthor = $res->docs[0]->author_name[0];
        $bookPages = $res->docs[1]->number_of_pages_median;
        $firstPublishYear = $res->docs[1]->first_publish_year;

        echo '<h2>Titulo:'.$bookTitle.'</h2>';
        echo '<h3>Autor:'.$bookAuthor.'</h3>';
        echo '<h3>Paginas:'.$bookPages.'</h3>';
        echo '<h3>Publicado em:'.$firstPublishYear.'</h3>';
        curl_close($curl);
    }
    ?>
    </div>

    <div id='center'>
    <?php
    if ($_POST['bookAuthor']!=null){
        $author = $_POST['bookAuthor'];
        $bookAuthor = $author;
        for ($i=0;$i<strlen($author);$i++){
            if ($author[$i] == ' '){
                $author[$i] = '+';
            }
        }
        $url = 'http://openlibrary.org/search.json?author='.$author;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $res = json_decode(curl_exec($curl));

        $subject = null;

        echo "<h1>Livros do autor ".$bookAuthor.':</h1><br>';

        for($i=0;$i<sizeof($res->docs);$i++){
            echo $res->docs[$i]->title.'<br>';
        }
        //var_dump($res->docs[0]);
        curl_close($curl);
    }

    ?>
    </div>

    <div id='right'>
    <?php
    if ($_POST['tvShow']!=null){
        $tvShow = $_POST['tvShow'];
        $tvShow2 = $tvShow;
        for ($i=0;$i<strlen($tvShow);$i++){
            if ($tvShow[$i] == ' '){
                $tvShow[$i] = '+';
            }
        }
        $url = 'https://api.tvmaze.com/search/shows?q='.$tvShow;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $res = json_decode(curl_exec($curl));

        $genre = $res[0]->show->genres[0];
        $runTime = $res[0]->show->runtime;
        $ended = $res[0]->show->ended;
        $rating = $res[0]->show->rating->average;
        $network = $res[0]->show->network->name;

        echo "<h1>Dados do show ".$tvShow2.":</h1><br>";
        echo "Genero: ".$genre.'<br>';
        echo "Duração: ".$runTime.'<br>';
        echo "Terminou em : ".$ended.'<br>';
        echo "Nota: ".$rating.'<br>';
        echo "Emissora: ".$network.'<br>';
        curl_close($curl);
    }

    ?>
    </div>


    

</body>
</html>