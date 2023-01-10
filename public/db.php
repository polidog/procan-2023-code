<?php
// db.php

$pdo = new PDO('mysql:host=db;port=3306;dbname=wishlist', 'shizuoka', 'fujiyama'); // データベースへの接続
$stmt = $pdo->query("SELECT * FROM items"); // クエリの実行

?>
<html>
  <body>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>商品名</th>
          <th>商品コード</th>
          <th>画像</th>
          <th>いいね数</th>
          <th>登録日</th>
          <th>更新日</th>
          <th></th>
        </tr>
      </thead>
      <?php foreach ($stmt as $books) : ?>
      <tr>
        <td><?php echo $books['id'] ?></td>
        <td><?php echo $books['name'] ?></td>
        <td><?php echo $books['item_code'] ?></td>
        <td>
          <?php if ($books['image'] !== null) : ?>
            <img src="<?php echo $books['image'] ?>" />
          <?php endif; ?>
        </td>
        <td>
          <td><?php echo $books['like_count'] ?></td>
        </td>
        <td>
          <?php echo (new \DateTime($books['created_at']))->format('Y年m月d日 H時i分s秒') ?>
        </td>
        <td>
          <?php echo (new \DateTime($books['updated_at']))->format('Y年m月d日 H時i分s秒') ?>
        </td>
        <td></td>
      </tr>
      <?php endforeach; ?>
    </table>
  </body>
</html>