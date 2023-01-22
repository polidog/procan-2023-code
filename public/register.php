<?php

/**
 * 商品が登録されているか判定する関数
 */
$hasItem = static function(PDO $pdo, string $itemCode): bool {

    // すでに登録があるか確認する
    $stmt = $pdo->prepare("SELECT * FROM items WHERE item_code = :itemCode"); // クエリの実行
    $stmt->bindParam(':itemCode', $itemCode);
    $stmt->execute();

    return !empty($stmt->fetchAll());
};

/**
 * 商品を登録するための関数
 */
$register = static function(PDO $pdo, string $itemCode, string $name): void {
    $stmt = $pdo->prepare("INSERT INTO items (item_code, name, created_at, updated_at) VALUES (:itemCode, :name, now(), now())");
    $stmt->bindValue(':itemCode', $itemCode);
    $stmt->bindValue(':name', $name);
    $stmt->execute();
};



$itemCode = $_GET['itemCode'] ?? null;
$itemName = $_GET['itemName'] ?? null;

if (null === $itemCode) {
    // itemCodeが指定されてないためsearch.phpにリダイレクト
    header('Location: search.php');
    exit;
}

$search = $_GET['search'] ?? null;

// データベースへの接続
$pdo = new PDO('mysql:host=db;port=3306;dbname=wishlist', 'shizuoka', 'fujiyama'); // データベースへの接続

if (false === $hasItem($pdo, $itemCode)) {
    // 商品が登録されていなければ、商品を登録する
    $register($pdo, $itemCode, $itemName);
}

header('Location: search.php?search=' . $search);
