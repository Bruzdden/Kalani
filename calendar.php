<?php
require_once("graphql.php");
require_once "MySQLiDB.php";
require __DIR__ . '/vendor/autoload.php';

$animeSearch = new AnimeSearch;

if (!isset($_SESSION["name"])) {
    header("Location: login.php");
    exit();
}

use benhall14\phpCalendar\Calendar as Calendar;
			
$db = new MySQLiDB();
$db->_connect();

$calendar = new Calendar;
$calendar->stylesheet();


?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="calendar.css">
	<link rel="stylsheet" type="text/css" href="/vendor/benhall14/php-calendar/html/css/calendar.min.css">
	<link rel="icon" type="image/x-icon" href="favicon.ico">
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
                $sumary = $animeTitle . "</br>" . $airingDate . "</br>";
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
</body>
