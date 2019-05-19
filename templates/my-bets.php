<main>
    <?= $nav; ?>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
            <?php foreach ($items as $item) : ?>
                <tr class="rates__item <?= $item['status'][2] ?? ''; ?>">
                    <td class="rates__info">
                        <div class="rates__img">
                            <img src="./uploads/<?= $item['photo_url']; ?>" width="54" height="40" alt="Сноуборд">
                        </div>
                        <div>
                            <h3 class="rates__title"><a href="lot.php<?= htmlspecialchars('?id=' . $item['id']); ?>"><?= htmlspecialchars($item['name']); ?></a></h3>
                            <?php if ($item['status'][0] === 'timer--win') : ?><p><?= $item['description']; ?></p>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="rates__category">
                        <?= htmlspecialchars($item['category']); ?>
                    </td>
                    <td class="rates__timer">
                        <div class="timer <?= $item['status'][0]; ?>"><?= $item['status'][1]; ?></div>
                    </td>
                    <td class="rates__price">
                        <?= format_price($item['current_price']); ?>
                    </td>
                    <td class="rates__time">
                        <?= htmlspecialchars($item['time_ago']); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
</main>