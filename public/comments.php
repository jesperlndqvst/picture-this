<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/views/navigation.php'; ?>

<?php authenticateUser() ?>

<?php if (isset($_GET['id'])) {
    $postId = $_GET['id'];
}
?>

<article class="comments">
    <form class="form form--comments" action="/app/posts/comments.php?id=<?= $postId ?>" method="post">
        <a href="/#<?= $postId ?>">Return</a>
        <input class="form__input" type="text" name="comment" placeholder="Comment" autocomplete="off" required>
        <button class="btn btn--lg" type="submit" name="submit">Comment</button>
    </form>


    <?php $comments = getComments($postId, $pdo) ?>
    <?php foreach ($comments as $comment) : ?>
        <div class="comments-content">
            <img src="app/uploads/avatars/<?= $comment['avatar'] ?>" alt="User avatar">
            <p>
                <span class="text-bold"><?= $comment['username'] ?></span>
                <?= $comment['comment'] ?>
            </p>
            <p><?= $comment['date'] ?></p>
        </div>
    <?php endforeach; ?>




</article>





<?php require __DIR__ . '/views/footer.php'; ?>
