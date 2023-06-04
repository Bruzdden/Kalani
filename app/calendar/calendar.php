<?php
require_once(dirname(__DIR__)."/graphql/graphql.php");
require_once(dirname(__DIR__)."/db/MySQLiDB.php");
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once("calendarClass.php");

$animeSearch = new AnimeSearch;

if (!isset($_SESSION["name"])) {
    header("Location: /app/login/login.php");
    exit();
}

			
$db = new MySQLiDB();


$calendar = new Calendar();
$calendar->stylesheet();


?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/app/css/style.css">
	<link rel="stylesheet" href="/app/css/calendar.css">
	<link rel="stylsheet" type="text/css" href="/vendor/benhall14/php-calendar/html/css/calendar.min.css">
	<link rel="icon" type="image/x-icon" href="/app/res/img/favicon.ico">
	<title>Kalani</title>
</head>

<body>

	<?php
	require_once("header.php");

	?>
    <?php

    if (isset($_SESSION["name"])) {
        $select = $db->_select('anime', [], ['idUser' => $_SESSION['idUser']]);

        $response = $animeSearch->getClient()->post('https://graphql.anilist.co', [
            'json' => [
                'query' => $animeSearch->getQuery(),
            ],
        ]);
        $data = json_decode($response->getBody(), true);
        
        $animeMap = [];
        foreach ($data['data']['Page']['media'] as $anime) {
            $animeMap[$anime['id']] = $anime['title']['english'];
        }
        
        $events = [];
        foreach ($select as $anime) {
            $airingDate = date("Y-m-d", strtotime($anime["airingDate"]));
            $idAnime = (string)$anime["idAnime"];
            
            if (isset($animeMap[$idAnime])) {
                $animeTitle = $animeMap[$idAnime];
                $sumary = "</br>" . $animeTitle . "</br>" . $airingDate . "</br>";
                $events[] = [
                    'start' => $airingDate,
                    'end' => $airingDate,
                    'mask' => true,
                    'summary' => $sumary,
                ];
            }
        }
        $calendar->addEvents($events);
    }

    $calendar->display();
    ?>
    <script src="../app/js/script.js"></script>
</body>
