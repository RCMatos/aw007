
<?php

    //include_once "utils/dbpedia.php";
    //include_once "utils/request.php";
    include_once "../webservices/dbpediaDiseases.php";
    include_once "../webservices/pubmedSearch.php";
    include_once "../webservices/pubmedFeach.php";
    include_once "../webservices/flickr.php";
    include_once "../webservices/twitterSearch.php";
    include_once "../webservices/twitterEmbed.php";

    echo "Hello World";

    $dbPediaDiseases = new DBPediaDiseases(5);

    //$response = $dbPediaDiseases->getResponseDiseasesJson();

    $diseases = $dbPediaDiseases->getDiseases();

    //obter o url para fazer o pedido http
    //$requestURL = getUrlDbpediaDiseasesJson();

    //usar o curl para fazer o pedido e retornar a resposta
    
    //$response =  json_decode(getResponseCurl($requestURL),true);
    
    
    echo '<h1>Diseases</h1>';

    //var_dump($diseases);
    //echo $diseases[0]['wikiPageID'];
    foreach($diseases as $disease){
        echo '<p>'.'<b>Id</b>: '.$disease['wikiPageID']['value'].'</p>';
        echo '<p>'.'<b>Label</b>: '.$disease['label']['value'].'</p>';
        echo '<p> <b>Abstract</b>: '.$disease['abstract']['value'].'</p>';
        echo '<hr>';
    }

    $label = $diseases[3]['label']['value'];

    echo '<h1>PubMed Search</h1>';

    $pubmed = new PubMedSearch($label,1);

    $response = $pubmed->getIdLists();

    echo '<p> <b>Label</b>: '.$label.'</p>';
    echo '<p> <b>PubMed Id</b>: '.$response['Id'].'</p>';

    echo '<hr>';
    echo '<h1>PubMed Feach Disease</h1>';
    echo '<b>Label</b> :'.$label;

    $pubmedFeach = new PubMedFech($response['Id']);
    $article = $pubmedFeach->getResponse();

    //$article = $article['PubmedArticle']['MedlineCitation']['Article'];
    //var_dump($article['PubmedArticle']['PubmedData']['History']['PubMedPubDate']);

    echo '<p> <b>Titulo Artigo: </b>'.$pubmedFeach->getArticleTitle().'</p>';
    echo '<p> <b>Abstract: </b>'.$pubmedFeach->getArticleAbstract().'</p>';
    //$dataArtigo = $article['Journal']['JournalIssue']['PubDate'];
    echo '<p> <b>Data do artigo: </b>'.$pubmedFeach->getArticleDate().'</p>';
    echo '<p> <b>Data de publicação do artigo: </b>'.$pubmedFeach->getArticlePubDate().'</p>';
    $authors = $pubmedFeach->getArticleAuthors();
    echo '<p> <b>Autores do artigo: </b>';
    foreach($authors as $author){
        echo ''.$author.' |';
    }
    echo '</p>';
    


    echo '<hr>';
    echo '<h2>Photos Disease</h2>'.$label.'';

    $flickr = new Flickr($label,5);
    $photos = $flickr->getResponse();

    //var_dump($photos);
    //var_dump($photos['photos']['photo']);

    $photosUrl = $flickr->getPhotosUrl();

    foreach($photosUrl as $key=>$photo){
        echo '<p>Photo ID: '.$key.'</p>';
        echo '<p>Photo URL: '.$photo[0].'</p>';
        echo '<p>Image:<br> <img src="'.$photo[0].'" alt="..." width="300" height="200"></br></p>';
    }

    echo '<hr>';
    echo '<h2>Twitter Disease </h2>'.$label.'';


    $twitter = new TwitterSearch($label);
    $tweets = $twitter->getTweets();
    //var_dump($tweets[1]);
    //echo $twitter->getTweetId($tweets[1]);

    $twitter_embed = new TwitterEmbed($twitter->getTweetId($tweets[1]));
    //var_dump($twitter_embed->getResponse());
    $twiiter_embed = $twitter_embed->getResponse();
    $html = $twiiter_embed['html'];

    echo $html;










?>