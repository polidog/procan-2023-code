<?php

// データベースへの接続
$pdo = new PDO('mysql:host=db;port=3306;dbname=wishlist', 'shizuoka', 'fujiyama'); // データベースへの接続

// 登録している商品を取得する
$items = $pdo->query('SELECT * FROM items')->fetchAll();
?>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>欲しい物リスト -　一覧</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<main class="container">
  <h1 class="my-3">欲しい物リスト - 一覧</h1>
  <div class="my-3">
    <a href="/search.php">欲しい物検索へ</a>
  </div>
  <table class="table table-bordered">
    <thead>
    <tr>
      <th>ID</th>
      <th>商品名</th>
      <th>商品画像</th>
      <th>いいね数</th>
      <th>登録日時</th>
      <th>更新日時</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($items as $item): ?>
      <tr>
        <td><?php echo $item['id']?></td>
        <td><?php echo $item['name']?></td>
        <td><?php echo $item['image']?></td>
        <td><?php echo $item['like_count']?></td>
        <td><?php echo $item['created_at']?></td>
        <td><?php echo $item['updated_at']?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</main>
</body>
</html>
