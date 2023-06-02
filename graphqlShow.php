<?php

require_once("graphql.php");
require_once("header.php");

$searchInput = $_POST['search'];

$animeSearch = new AnimeSearch();
$html = $animeSearch->search($searchInput);

echo $html;


?>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: Arial, sans-serif;
    }
    .section {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f2f2f2;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .item-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        align-items: flex-start;
        gap: 20px;
    }

    .item {
        flex: 0 0 calc(33.33% - 10px);
        margin-bottom: 20px;
        text-align: center;
        box-sizing: border-box;
        padding: 10px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .item img {
        max-width: 100%;
        height: auto;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    @media screen and (max-width: 767px) {
        .item {
            flex: 0 0 calc(50% - 10px);
        }
    }

    @media screen and (max-width: 479px) {
        .item {
            flex: 0 0 100%;
        }
    }
</style>

<body>
    <script src="script.js"></script>
</body>