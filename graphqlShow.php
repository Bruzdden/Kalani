<?php

require_once("graphql.php");
require_once("header.php");

$searchInput = $_POST['search'];

$animeSearch = new AnimeSearch();
$html = $animeSearch->search($searchInput);

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