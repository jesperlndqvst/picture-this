<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/views/navigation.php'; ?>


<article class="search">
    <form action="search.php" method="get">
        <input class="form__input" type="text" name="search" placeholder="Username" value autocomplete="off" required>
        <button class="btn btn--lg" type="submit">Search</button>
    </form>

    <?php if (isset($_GET['search'])) : ?>
        <?php $searchResults = getSearchResult($_GET['search'], $pdo) ?>
        <?php foreach ($searchResults as $searchResult) : ?>
            <a href="/profile.php?id=<?= $searchResult['id'] ?>&username=<?= $searchResult['username'] ?>">
                <div class="search-result">
                    <img class="search-result__img" src="app/uploads/avatars/<?= $searchResult['avatar'] ?>" alt="profile image">
                    <p><?= $searchResult['username'] ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>

</article>


<?php if (isset($_SESSION['errors'])) : ?>
    <?php foreach ($_SESSION['errors'] as $error) : ?>
        <p><?= $error ?></p>
    <?php endforeach; ?>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<?php require __DIR__ . '/views/footer.php'; ?> 
