<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category) : ?>
            <li class="nav__item <?= $category['name'] === $cat_class ? 'nav__item--current' : '';  ?>">
                <a href="all-lots.php<?= htmlspecialchars('?search=' . $category['name']); ?>"><?= htmlspecialchars($category['name']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>