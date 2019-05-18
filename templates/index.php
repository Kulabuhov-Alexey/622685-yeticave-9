<main class="container">
    <?= $promo; ?>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <?php foreach ($items as $item) : ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= 'uploads/' . htmlspecialchars($item['photo_url']); ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= htmlspecialchars($item['category']); ?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php<?= htmlspecialchars('?id=' . $item['id']); ?>"><?= htmlspecialchars($item['name']); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount"><?= htmlspecialchars($item['start_price']); ?></span>
                                <span class="lot__cost"><?= format_price(htmlspecialchars($item['current_price'])); ?></span>
                            </div>
                            <div class="lot__timer timer <?= $item['status'][0]; ?>">
                            <?= $item['status'][1]; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>