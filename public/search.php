<?php
require __DIR__ . '/views/header.php';
require __DIR__ . '/views/navigation.php';
authenticateUser($pdo);
?>

<article class="search">

    <h2 class="heading-l">Search for users</h2>

    <?php if (isset($_SESSION['errors'])) : ?>
        <div class="errors">
            <?php foreach ($_SESSION['errors'] as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <form class="form form--search" action="app/users/search.php" method="post">
        <input class="form__input" type="text" name="search" placeholder="Username" value autocomplete="off" required>
    </form>
    <div class="search-result-container">

    </div>


</article>


<?php require __DIR__ . '/views/footer.php'; ?> 
