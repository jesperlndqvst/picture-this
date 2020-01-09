<?php
require __DIR__ . '/views/header.php';
require __DIR__ . '/views/navigation.php';
authenticateUser();
$user = getUserById($_SESSION['user']['id'], $pdo);


if (isset($_GET['id'])) {
    $postId = $_GET['id'];
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
                 <!-- If comment is writen by user OR if post is written by user -->
                <?php if ($comment['user_id'] === $user['id']) : ?>
                    <a href="/app/posts/comments.php?id=<?=$postId?>&&commentId=<?=$comment['id']?>">
                    <img src="assets/images/delete.svg" alt="delete"></a>
                <?php endif; ?>
            </div>

        </div>
    <?php endforeach; ?>

</article>

<?php require __DIR__ . '/views/footer.php'; ?>
