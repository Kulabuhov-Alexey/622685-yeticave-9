<?php foreach ($categories as $category) : ?>
    <li class="nav__item">
        <a href="pages/all-lots.html"><?= htmlspecialchars($category['name']); ?></a>
    </li>
<?php endforeach; ?>