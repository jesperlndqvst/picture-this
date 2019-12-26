<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/views/navigation.php'; ?>

<?php authenticateUser() ?>

<?php if (isset($_GET['id'])) {
    $postId = $_GET['id'];
}
?>
<h1>Comments</h1>
<form class="form form--comments" action="/app/posts/comments.php?id=<?= $postId ?>" method="post">
    <a href="/">Return</a>
    <label for="comment">Comments...</label>
    <input type="text" name="comment" required>
    <button type="submit" name="submit">Submit</button>
    <?php $comments = getComments($postId, $pdo) ?>
    <?php foreach ($comments as $comment) : ?>
        <div class="form--comments__content">
            <img src="app/uploads/avatars/<?= $comment['avatar'] ?>" alt="User avatar">
            <p>
                <span><?= $comment['username'] ?></span>
                <?= $comment['comment'] ?>
            </p>
            <p><?= $comment['date'] ?></p>
        </div>
    <?php endforeach; ?>
</form>


<?php require __DIR__ . '/views/footer.php'; ?>
