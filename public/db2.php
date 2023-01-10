<?php
// db2.php

$pdo = new PDO('mysql:host=db;port=3306;dbname=wishlist', 'shizuoka', 'fujiyama'); // データベースへの接続

if (isset($_GET['action']) && $_GET['action'] === 'update' && isset($_GET['id'])) {
  // 既読処理を行う
  $stmt = $pdo->prepare('UPDATE items SET like_count = like_count + 1 WHERE id = ?');
  $stmt->bindValue(1, $_GET['id'],PDO::PARAM_INT);
  $stmt->execute();

  // このまま表示してしまうとリロードするたびに「いいね」が増えてしまうので
  // ここでリダイレクト処理を行う
  $redirectUrl = sprintf("http://%s/%s", $_SERVER['SERVER_NAME'], $_SERVER['SCRIPT_NAME']);
  header('Location: ' . $redirectUrl);
}

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
          <td>
            <?php echo $books['like_count'] ?>
            <a href="<?php echo sprintf('?action=update&id=%d', $books['id']); ?>">いいね</a>する
          </td>
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