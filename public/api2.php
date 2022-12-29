<?php


const APP_ID = 'xxxxx'; // Application ID
const BASE_API_URL = 'https://app.rakuten.co.jp/services/api/IchibaItem/Search/20170706?applicationId=%s&keyword=%s&formatVersion=2'; // APIのURL

// 検索したい商品名
$keyword = $_GET['search'];

// 検索するURLを生成する https://app.rakuten.co.jp/services/api/IchibaItem/Search/20170706?applicationId=xxxxxx&keyword=ソファ&formatVersion=2
$url = sprintf(BASE_API_URL, APP_ID, $keyword);

// APIからデータを取得する
$content = file_get_contents($url);

// JSON形式のデータを連想配列に変換する
$json = json_decode($content, true);
?>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>欲しい物リスト - 検索</title>
</head>
<body>
    <h1>欲しい物リスト - 検索</h1>
    <ul>
        <?php foreach ($json['Items'] as $item): ?>
            <li>
                <a href="<?php echo $item['itemUrl']; ?>" target="_blank">
                    <?php if (isset($item['mediumImageUrls'][0])) : ?>
                    <img src="<?php echo $item['mediumImageUrls'][0]; ?>" alt="">
                    <?php endif; ?>
                </a>
                <p><?php echo $item['itemName']; ?></p>
                <p><?php echo $item['itemPrice']; ?>円</p>
            </li>
        <?php endforeach; ?>
    </ul>
</html>
