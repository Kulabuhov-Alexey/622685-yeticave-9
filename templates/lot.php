<main>
    <?= $nav; ?>
    <section class="lot-item container">
        <h2><?= $item[0]['name']; ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?= 'uploads/' . $item[0]['photo_url']; ?>" width="730" height="548" alt="Сноуборд">
                </div>
                <p class="lot-item__category">Категория: <span><?= $item[0]['category']; ?></span></p>
                <p class="lot-item__description"><?= $item[0]['description']; ?></p>
            </div>
            <div class="lot-item__right">
                <?php if (!empty($active_user)) : ?>
                    <div class="lot-item__state">
                        <div class="lot-item__timer timer <?= $item[0]['status'][0]; ?>">
                            <?= $item[0]['status'][1]; ?>
                        </div>
                        <div class="lot-item__cost-state">
                            <div class="lot-item__rate">
                                <span class="lot-item__amount">Текущая цена</span>
                                <span class="lot-item__cost"><?= format_price($item[0]['current_price']); ?></span>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span><?= format_price($item[0]['step_call']); ?></span>
                            </div>
                        </div>
                        <form class="lot-item__form <?= $errors ? 'form__item--invalid' : ''; ?>" action="lot.php<?= htmlspecialchars('?id=' . $item[0]['id']); ?>" method="post" enctype="multipart/form-data">
                            <p class="lot-item__form-item form__item">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="text" name="cost" placeholder="Введите ставку" value="<?= $post['cost'] ?? ''; ?>">
                                <span class="form__error"><?= $errors['cost'] ?? ''; ?></span>
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form>
                    </div>
                <?php endif; ?>
                <div class="history">
                    <h3>История ставок (<span><?= count($bet_history); ?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($bet_history as $key => $value) : ?>
                            <tr class="history__item">
                                <td class="history__name"><?= htmlspecialchars($bet_history[$key]['name']); ?></td>
                                <td class="history__price"><?= format_price(htmlspecialchars($bet_history[$key]['price'])); ?></td>
                                <td class="history__time"><?= htmlspecialchars($bet_history[$key]['time_ago']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>