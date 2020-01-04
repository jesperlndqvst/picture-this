<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/views/navigation.php'; ?>

<?php authenticateUser() ?>

<?php if (isset($_GET['id'])) {
    $postId = $_GET['id'];
}
?>

<article class="comments">
    <form class="form form--comments" action="/app/posts/comments.php?id=<?= $postId ?>" method="post">
        <input class="form__input" type="text" name="comment" placeholder="Comment" autocomplete="off" required>
        <button class="btn btn--lg" type="submit" name="submit">Comment</button>
    </form>
    <a href="/#<?= $postId ?>"><button class="btn btn--lg" type="submit" name="submit">Return</button></a>

    <?php $comments = getComments($postId, $pdo) ?>
    <?php foreach ($comments as $comment) : ?>
        <div class="comments-content">
            <img src="app/uploads/avatars/<?= $comment['avatar'] ?>" alt="User avatar">
            <div class="comments-content__text">
                <p class="text-bold"><?= $comment['username'] ?></p>
                <p><?= $comment['comment'] ?></p>
                <p><?= $comment['date'] ?></p>
            </div>
        </div>
    <?php endforeach; ?>

</article>

<?php require __DIR__ . '/views/footer.php'; ?>
