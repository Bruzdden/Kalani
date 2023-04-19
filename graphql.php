<?php
require __DIR__ . '/vendor/autoload.php';

$client = new \GuzzleHttp\Client([
    'verify' => false,
]);

$query = <<<'QUERY'
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
        }
    }
}
QUERY;

// Get the search input from the form
$searchInput = $_POST['search'];

// Replace the 'search' variable in $variables with the search input
$variables = [
    'search' => $searchInput,
];

$response = $client->post('https://graphql.anilist.co', [
    'json' => [
        'query' => $query,
        'variables' => $variables,
    ],
]);

$data = json_decode($response->getBody(), true);

$html = '<div class="section"><h2>Search Results</h2>';

foreach ($data['data']['Page']['media'] as $anime)
{
    // Store the media ID in a variable
    $mediaId = $anime['id'];

    $html .= '<div class="item">';
    $html .= '<img src="' . $anime['coverImage']['medium'] . '" alt="' . $anime['title']['english'] . '">';
    $html .= '<h3>' . $anime['title']['english'] . '</h3>';
    $html .= '<p>' . $anime['title']['romaji'] . '</p>';

    if (isset($anime['id'])) {
        $html .= '<p>ID: ' . $anime['id'] . '</p>';
    } else {
        $html .= '<p>ID: N/A</p>';
    }

    $html .= '<button type="submit">+</button>';
    $html .= '</div>';
}

$html .= '</div>'; // Close the div.section

echo $html;

?>

<style>
    .section {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .item-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .item {
        width: calc(33.33% - 10px);
        margin-bottom: 20px;
        text-align: center;
        box-sizing: border-box;
        padding: 10px;
    }

    .item img {
        max-width: 100%;
        height: auto;
        margin-bottom: 10px;
    }

    @media screen and (max-width: 767px) {
        .item {
            width: calc(50% - 10px);
        }
    }

    @media screen and (max-width: 479px) {
        .item {
            width: 100%;
        }
    }
</style>
