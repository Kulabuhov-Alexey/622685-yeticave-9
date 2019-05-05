 <main>
     <nav class="nav">
         <ul class="nav__list container">
             <?php foreach ($categories as $category) : ?>
                 <li class="nav__item">
                     <a href="pages/all-lots.html"><?= htmlspecialchars($category['name']); ?></a>
                 </li>
             <?php endforeach; ?>
         </ul>
     </nav>
     <form class="form form--add-lot container <?php if (isset($errors)) {
                                                    echo 'form--invalid';
                                                } ?>" action="add.php" method="post" enctype="multipart/form-data">
         <h2>Добавление лота</h2>
         <div class="form__container-two">
             <div class="form__item <?php if (!empty($errors['lot-name'])) {
                                        echo 'form__item--invalid';
                                    } ?>">
                 <label for="lot-name">Наименование <sup>*</sup></label>
                 <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?= $post['lot-name'] ?? ''; ?>">
                 <span class="form__error"><?= $errors['lot-name']; ?></span>
             </div>
             <div class="form__item <?php if (!empty($errors['category'])) {
                                        echo 'form__item--invalid';
                                    } ?>">
                 <label for="category">Категория <sup>*</sup></label>
                 <select id="category" name="category">
                     <option>Выберите категорию</option>
                     <?php foreach ($categories as $category) : ?>
                         <option <?php if (!empty($post['category']) && $category['name'] == $post['category']) {
                                        print('selected');
                                    } ?>><?= htmlspecialchars($category['name']); ?></option>
                     <?php endforeach; ?>
                 </select>
                 <span class="form__error"><?= $errors['category']; ?></span>
             </div>
         </div>
         <div class="form__item form__item--wide <?php if (!empty($errors['message'])) {
                                                        echo 'form__item--invalid';
                                                    } ?>">
             <label for="message">Описание <sup>*</sup></label>
             <textarea id="message" name="message" placeholder="Напишите описание лота"><?= $post['message'] ?? ''; ?></textarea>
             <span class="form__error"><?= $errors['message']; ?></span>
         </div>
         <div class="form__item form__item--file">
             <label>Изображение <sup>*</sup></label>
             <div class="form__input-file <?php if (!empty($errors['pic'])) {
                                                echo 'form__item--invalid';
                                            } ?>">
                 <input class="" type="file" id="lot-img" value="" name="pic">
                 <span class="form__error"><?= $errors['pic']; ?></span>
             </div>
         </div>
         <div class="form__container-three">
             <div class="form__item form__item--small <?php if (!empty($errors['lot-rate'])) {
                                                            echo 'form__item--invalid';
                                                        } ?>">
                 <label for="lot-rate">Начальная цена <sup>*</sup></label>
                 <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?= $post['lot-rate'] ?? ''; ?>">
                 <span class="form__error"><?= $errors['lot-rate']; ?></span>
             </div>
             <div class="form__item form__item--small <?php if (!empty($errors['lot-step'])) {
                                                            echo 'form__item--invalid';
                                                        } ?>">
                 <label for="lot-step">Шаг ставки <sup>*</sup></label>
                 <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?= $post['lot-step'] ?? ''; ?>">
                 <span class="form__error"><?= $errors['lot-step']; ?></span>
             </div>
             <div class="form__item <?php if (!empty($errors['lot-date'])) {
                                        echo 'form__item--invalid';
                                    } ?>">
                 <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
                 <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= $post['lot-date'] ?? ''; ?>">
                 <span class="form__error">Введите дату завершения торгов</span>
             </div>
         </div>
         <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
         <button type="submit" class="button">Добавить лот</button>
     </form>
 </main>