<?php

$id = $_SESSION['user']['id'];

$query = 'SELECT media, description, date(date), user_id FROM posts WHERE user_id = :id';
$statement = $pdo->prepare($query);
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<?php if ($posts) : ?>
    <?php foreach ($posts as $post) : ?>
        <img src="<?= $post['media'] ?>" alt="">
        <p><?= $post['description'] ?></p>
        <p><?= $post['date(date)'] ?></p>
    <?php endforeach; ?>
    <?php else: ?>
        <p>No posts to show</p>
<?php endif; ?>
