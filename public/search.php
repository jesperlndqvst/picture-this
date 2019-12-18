<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/views/navigation.php'; ?>


<form action="/app/users/search.php" method="get">
    <label for="search">Search</label>
    <input type="text" name="search" required>
    <button type="submit">Search</button>
</form>


<?php if (isset($_SESSION['searchResults'])) : ?>
    <?php $searchResults = $_SESSION['searchResults'] ?>
    <?php foreach ($searchResults as $searchResult) : ?>
        <a href="/profile.php?id=<?= $searchResult['id'] ?>&username=<?= $searchResult['username'] ?>"><?= $searchResult['username'] ?></a>
    <?php endforeach; ?>
    <?php unset($_SESSION['searchResults']); ?>
<?php endif; ?>


<?php if (isset($_SESSION['errors'])) : ?>
    <?php foreach ($_SESSION['errors'] as $error) : ?>
        <p><?= $error ?></p>
    <?php endforeach; ?>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<?php require __DIR__ . '/views/footer.php'; ?> 
