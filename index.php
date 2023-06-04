<?php
require_once($_SERVER['DOCUMENT_ROOT'] ."/app/graphql/graphql.php");
require_once($_SERVER['DOCUMENT_ROOT'] ."/app/db/MySQLiDB.php");
// Create a new MySQLiDB instance
$db = new MySQLiDB();





?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/app/css/style.css">
	<link rel="stylesheet" href="/app/css/calendar.css">
	<link rel="stylsheet" type="text/css" href="/app/css/calendar.min.css">
	<link rel="icon" type="image/x-icon" href="/app/res/img/favicon.ico">
	<title>Kalani</title>
</head>

<body>

	<?php
	require_once("header.php");

	?>
	<div class="image-container">
		<img src="/app/res/img/kalani.png" alt="kalani">
	</div>


	<?php
	//require_once("graphql.php");
	$animeSearch = new AnimeSearch;

    $queryNew = <<<'QUERY'
            query ($search: String) {
                Page {
                    media (search: $search, type: ANIME, sort: START_DATE_DESC, status: RELEASING) {
                        id
                        title {
                            english
                            romaji
                        }
                        coverImage {
                            medium
                        }
                        startDate {
                            year
                            month
                            day
                        }
                        airingSchedule(notYetAired: true, perPage: 1) {
                            nodes {
                                episode
                                airingAt
                            }
                        }
                    }
                }
            }
            QUERY;
	$queryPopular = <<<'QUERY'
			query ($search: String) {
				Page {
					media (search: $search, type: ANIME, sort: TRENDING_DESC, status: RELEASING) {
						id
						title {
							english
							romaji
						}
						coverImage {
							medium
						}
						startDate {
							year
							month
							day
						}
						airingSchedule(notYetAired: true, perPage: 1) {
							nodes {
								episode
								airingAt
							}
						}
					}
				}
			}
			QUERY;

		$dataNew = $animeSearch->fetchData($queryNew);
		$dataPopular = $animeSearch->fetchData($queryPopular);

		$animeListNew = array_slice($dataNew, 0, 5);
		$animeListPopular = array_slice($dataPopular, 0, 5);

		$htmlContainerNew = $animeSearch->generateAnimeContainer($animeListNew, '5 Latest Anime');
		$htmlContainerPopular = $animeSearch->generateAnimeContainer($animeListPopular, '5 Trending Anime');

		echo $htmlContainerNew;
		echo $htmlContainerPopular;

	?>

	<section class="section">

		<div class="section">
		<a href="/app/calendar/calendar.php" class="a-calendar">
			<?php
			require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
			require_once($_SERVER['DOCUMENT_ROOT'] ."/app/calendar/calendarClass.php");

			$calendar = new Calendar();
			$calendar->stylesheet();





			if (isset($_SESSION["name"])) {
				$queryCalendar = <<<'QUERY'
				query ($search: String) {
					Page {
						media (search: $search, type: ANIME, sort: FAVOURITES_DESC, status: RELEASING) {
							id
							title {
								english
								romaji
							}
							coverImage {
								medium
							}
							startDate {
								year
								month
								day
							}
							airingSchedule(notYetAired: true, perPage: 1) {
								nodes {
									episode
									airingAt
								}
							}
						}
					}
				}
				QUERY;

				$dataCalendar = $animeSearch->fetchData($queryCalendar);
				$select = $db->_select('anime', [], ['idUser' => $_SESSION['idUser']]);


				$animeMap = [];
				foreach ($dataCalendar as $anime) {
					$animeMap[$anime['id']] = $anime['title']['english'];
				}

				$events = [];
				foreach ($select as $anime) {
					$airingDate = date("Y-m-d", strtotime($anime["airingDate"]));
					$idAnime = (string)$anime["idAnime"];

					if (isset($animeMap[$idAnime])) {
						$animeTitle = $animeMap[$idAnime];
						$summary = "</br>" . $animeTitle . "</br>" . $airingDate . "</br>";
						$events[] = [
							'start' => $airingDate,
							'end' => $airingDate,
							'mask' => true,
							'summary' => $summary,
						];
					}
				}
				$calendar->addEvents($events);
			}

			$calendar->display();





			?>
		</a>
		</div>

	</section>
	<footer>
	<div class="container">
		<div class="row">
		<div class="col-sm-6">
			<h3>Contact Us</h3>
			<p>Email: l.divoch@seznam.cz</p>
			<p>Phone: +420 776 394 802</p>
		</div>
		<div class="col-sm-6">
			<h3>Follow Us</h3>
			<p><a href="#">Instagram</a></p>
		</div>
		</div>
	</div>
	</footer>
	<script src="/app/js/script.js"></script>
</body>
</html>
