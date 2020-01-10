<?php
require __DIR__ . '/views/header.php';
require __DIR__ . '/views/navigation.php';
authenticateUser();
$user = getUserById($_SESSION['user']['id'], $pdo);

if (isset($_GET['id'])) {
    $postId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
}
$comments = getComments((int) $postId, $pdo);

?>

<article class="comments">
    <h2 class="heading-l">Comments</h2>
    <form class="form form--comments" action="/app/posts/comments.php?id=<?= $postId ?>" method="post">
        <input class="form__input" type="text" name="comment" placeholder="Comment" autocomplete="off" required>
        <button class="btn btn--lg" type="submit" name="submit">Comment</button>
    </form>
    <a href="/?id=<?= $postId ?>"><button class="btn btn--lg" type="submit" name="submit">Return</button></a>


    <?php foreach ($comments as $comment) : ?>
        <div class="comments-content">
            <div class="comments-content__left">
                <img src="app/uploads/avatars/<?= $comment['avatar'] ?>" alt="User avatar">
                <div class="comments-content__text">
                    <p class="text-bold"><?= $comment['username'] ?></p>
                    <p><?= $comment['comment'] ?></p>
                    <p class="text-date"><?= dateFormat($comment['date']) ?></p>
                </div>
            </div>
            <div class="comments-content__right">
                <?php if (
                    $user['id'] === $comment['comment_author'] ||
                    isPostAuthor($postId, $pdo) === true
                ) : ?>

                    <form class="form form--comment-delete" action="/app/posts/comments.php?id=<?= $postId ?>" method="post">
                        <input type="hidden" name="id" value="<?= $comment['comment_id']?>">
                        <button type="submit" name="submit">
                            <img src="assets/images/delete.svg" alt="delete">
                        </button>
                    </form>

                <?php endif; ?>
            </div>

        </div>
    <?php endforeach; ?>

</article>

<?php require __DIR__ . '/views/footer.php'; ?>
