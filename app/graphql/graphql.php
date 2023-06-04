<?php
session_start();

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once(dirname(__DIR__)."../db/MySQLiDB.php");
// Create a new MySQLiDB instance
$db = new MySQLiDB();



use GuzzleHttp\Client;

class AnimeSearch
{
    private $client;
    private $query;

    public function __construct()
    {
        $this->client = new Client(['verify' => false]);
        $this->query = <<<'QUERY'
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
    }
    public function getClient()
    {
        return $this->client;
    }
    public function getQuery()
    {
        return $this->query;
    }
    
    public function fetchData($query)
    {
        $client = new Client(['verify' => false]);
        
        $response = $client->post('https://graphql.anilist.co', [
            'json' => [
                'query' => $query,
            ],
        ]);
        
        $data = json_decode($response->getBody(), true);
        
        return $data['data']['Page']['media'];
    }

    public function generateAnimeContainer($animeList, $title)
    {
        $htmlContainer = '<div class="anime-container-new">';
        $htmlContainer .= "<h2>$title</h2>";
        
        foreach ($animeList as $anime) {
            $animeTitle = $anime['title']['english'];
            $animeCoverImage = $anime['coverImage']['medium'];
            
            $htmlContainer .= '<div class="anime-item-new">';
            $htmlContainer .= '<img src="' . $animeCoverImage . '" alt="' . $animeTitle . '">';
            $htmlContainer .= '<h3>' . $animeTitle . '</h3>';
            $htmlContainer .= '</div>';
        }
        
        $htmlContainer .= '</div>';
        
        return $htmlContainer;
    }

    public function search($searchInput)
    {
        $variables = [
            'search' => $searchInput,
        ];

        $response = $this->client->post('https://graphql.anilist.co', [
            'json' => [
                'query' => $this->query,
                'variables' => $variables,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        $html = '<div class="section"><h2>Search Results</h2>';

        foreach ($data['data']['Page']['media'] as $anime) {
            $html .= $this->renderAnime($anime);
        }

        $html .= '</div>'; // Close the div.section

        return $html;
    }

    private function renderAnime($anime)
    {
        $html = '<div class="item">';
        $html .= '<img src="' . $anime['coverImage']['medium'] . '" alt="' . $anime['title']['english'] . '">';
        $html .= '<h3>' . $anime['title']['english'] . '</h3>';
        $html .= '<p>' . $anime['title']['romaji'] . '</p>';

        $html .= $this->renderId($anime);
        $html .= $this->renderReleaseDate($anime);

        $latestEpisode = 'N/A';
        $airingDate = 'N/A';

        if (isset($anime['airingSchedule']['nodes'])) {
            foreach ($anime['airingSchedule']['nodes'] as $node) {
                if (isset($node['episode']) && isset($node['airingAt'])) {
                    $latestEpisode = $node['episode'];
                    $airingAt = $node['airingAt'];
                    $airingDate = date('Y-m-d H:i:s', $airingAt);
                    break;
                }
            }
        }

        $html .= '<p>Latest Episode: ' . $latestEpisode . '</p>';
        $html .= '<p>Airing Date: ' . $airingDate . '</p>';

        if ($latestEpisode == 'N/A' || $airingDate == 'N/A') {
            $html .= '<p>Cannot add to Calendar</p>';
        } else {
            $html .= $this->renderAddForm($anime);
        }

        $html .= '</div>';

        return $html;
    }

    private function renderId($anime)
    {
        if (isset($anime['id'])) {
            return '<p>ID: ' . $anime['id'] . '</p>';
        } else {
            return '<p>ID: N/A</p>';
        }
    }

    private function renderReleaseDate($anime)
    {
        if (isset($anime['startDate']['year']) && isset($anime['startDate']['month']) && isset($anime['startDate']['day'])) {
            $releaseDate = $anime['startDate']['year'] . '-' . $anime['startDate']['month'] . '-' . $anime['startDate']['day'];
            return '<p>Release Date: ' . $releaseDate . '</p>';
        } else {
            return '<p>Release Date: N/A</p>';
        }
    }

    private function renderAddForm($anime)
    {
        $html = '<form method="post"><input type="hidden" name="anime_id" value="' . $anime['id'] . '">';
        $html .= '<input type="hidden" name="release_date" value="' . $anime['startDate']['year'] . '-' . $anime['startDate']['month'] . '-' . $anime['startDate']['day'] . '">';
        $html .= '<input type="hidden" name="latest_episode" value="' . $anime['airingSchedule']['nodes'][0]['episode'] . '">';
        $html .= '<input type="hidden" name="airing_date" value="' . date('Y-m-d H:i:s', $anime['airingSchedule']['nodes'][0]['airingAt']) . '">';

        $dbConn = new MySQLiDB();
        $select = $dbConn->_select('anime', [], ['idUser' => $_SESSION['idUser'], 'idAnime' => $anime['id']]);
        if (count($select)) {
            $html .= '<button type="submit" name="add">Dislike</button></form>';
        } else{
            $html .= '<button type="submit" name="add">Like</button></form>';
        }
        return $html;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
        if (!isset($_SESSION["name"])) {
            header("Location: login.php");
            exit();
        }
        $animeId = $_POST["anime_id"];
        $release_Date = $_POST["release_date"];
        $latest_Episode = $_POST["latest_episode"];
        $airing_Date = $_POST["airing_date"];

        $_SESSION["animeId"] = $animeId;

        $user_data = array(
            "idUser" => $_SESSION['idUser'],
            "idAnime" => $animeId,
            "releaseDate" => $release_Date,
            "latestEpisode" => $latest_Episode,
            "airingDate" => $airing_Date
        );

        $select = $db->_select('anime', [], ['idUser' => $_SESSION['idUser'], 'idAnime' => $animeId]);
        if (count($select) == 1) {
            $delete = $db->_delete_anime('anime', [$_SESSION['idUser'], $animeId], ['idUser', 'idAnime']);
            if ($delete) {
                header('Location: index.php');
                exit();
            } else {
                $error = $db->getLastError();
                echo "Error deleting user: " . print_r($error, true);
            }
        }

        $insert = $db->_insert('anime', $user_data);

        if (!$insert) {
            $error_info = $db->getLastError();
            echo "Error: " . $error_info[2];
            exit();
        }

        header('Location: index.php');
        exit();
}





?>


