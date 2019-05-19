  <main>
      <?= $nav; ?>
      <div class="container">
          <section class="lots">
              <h2>Все лоты в категории <span><?= $title; ?></span></h2>
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
              <?php if (count($items) > 9) : ?>
                  <ul class="pagination-list">
                      <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
                      <li class="pagination-item pagination-item-active"><a>1</a></li>
                      <li class="pagination-item"><a href="#">2</a></li>
                      <li class="pagination-item"><a href="#">3</a></li>
                      <li class="pagination-item"><a href="#">4</a></li>
                      <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
                  </ul>
              <?php endif; ?>
          </section>
      </div>
  </main>