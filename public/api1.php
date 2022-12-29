<?php

const APP_ID = 'xxxx'; // Application ID
const BASE_API_URL = 'https://app.rakuten.co.jp/services/api/IchibaItem/Search/20170706?applicationId=%s&keyword=%s&formatVersion=2'; // APIのURL

// 検索したい商品名
$keyword = 'ソファ';

// 検索するURLを生成する https://app.rakuten.co.jp/services/api/IchibaItem/Search/20170706?applicationId=xxxxxx&keyword=ソファ&formatVersion=2
$url = sprintf(BASE_API_URL, APP_ID, $keyword);

// APIからデータを取得する
$content = file_get_contents($url);

// JSON形式のデータを連想配列に変換する
$json = json_decode($content, true);

echo '<pre>';
print_r($json);
