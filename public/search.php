<?php
const APP_ID = 'xxx'; // Application ID
const BASE_API_URL = 'https://app.rakuten.co.jp/services/api/IchibaItem/Search/20170706?applicationId=%s&keyword=%s&formatVersion=2'; // APIのURL

// 検索したい商品名
$search = $_GET['search'] ?? null;

// 検索用の関数の定義
$fnApiSearch = static function ($apiSearchWord): array {
    $url = sprintf(BASE_API_URL, APP_ID, $apiSearchWord);

    // APIからデータを取得する
    $content = file_get_contents($url);

    // JSON形式のデータを連想配列に変換する
    $json = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

    return $json['Items'];
};

$items = match($search) {
    null, '' => [],
    default => $fnApiSearch($search)
};

?>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>欲しい物リスト - 検索</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<main class="container">
  <h1 class="my-3">欲しい物リスト - 検索</h1>
  <div class="my-3">
    <a href="/list.php">欲しい物一覧へ</a>
  </div>
  <div>
    <form action="search.php" method="get">
      <input type="text" name="search" value="<?php echo $search; ?>">
      <input type="submit" value="検索">
  </div>
  <table class="table table-bordered">
    <thead>
    <tr>
      <th style="width: 20%">画像</th>
      <th style="width: 40%">商品名</th>
      <th>価格</th>
      <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>
      <tr>
        <td>
            <?php if (isset($item['mediumImageUrls'][0])) : ?>
              <img src="<?php echo $item['mediumImageUrls'][0]; ?>" alt="">
            <?php endif; ?>
        </td>
        <td>
            <?php echo $item['itemName']; ?>
        </td>
        <td>
            <?php echo $item['itemPrice']; ?>円
        </td>
        <td>
          <a href="<?php echo $item['itemUrl']; ?>" class="btn btn-dark btn-sm" target="_blank">商品情報へ</a>
          <a href="<?php echo sprintf('/register.php?itemCode=%s&itemName=%s&search=%s', $item['itemCode'], $item['itemName'], $search); ?>" class="btn btn-primary btn-sm">欲しい物リストへ登録</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <ul>
      <?php foreach ($items as $item): ?>
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
</main>
</body>
</html>
