<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <!--заполните этот список из массива категорий-->
        <?php foreach ($categories as $category) : ?>
            <li class="promo__item promo__item--<?= htmlspecialchars($category['symbol_code']); ?>">
                <a class="promo__link" href="pages/all-lots.html"><?= htmlspecialchars($category['name']); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>