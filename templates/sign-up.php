<main>
     <nav class="nav">
         <ul class="nav__list container">
             <?= $nav; ?>
         </ul>
     </nav>
     <form class="form container <?php if (isset($errors)) {
                                                    echo 'form--invalid';
                                                } ?>" action="sign-up.php" method="post" enctype="multipart/form-data">
      <h2>Регистрация нового аккаунта</h2>
      <div class="form__item <?php if (!empty($errors['email'])) {
                                        echo 'form__item--invalid';
                                    } ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $post['email'] ?? ''; ?>">
        <span class="form__error"><?= $errors['email']; ?></span>
      </div>
      <div class="form__item <?php if (!empty($errors['password'])) {
                                        echo 'form__item--invalid';
                                    } ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?= $errors['password']; ?></span>
      </div>
      <div class="form__item <?php if (!empty($errors['name'])) {
                                        echo 'form__item--invalid';
                                    } ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= $post['name'] ?? ''; ?>">
        <span class="form__error"><?= $errors['name']; ?></span>
      </div>
      <div class="form__item <?php if (!empty($errors['message'])) {
                                        echo 'form__item--invalid';
                                    } ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?= $post['message'] ?? ''; ?></textarea>
        <span class="form__error"><?= $errors['message']; ?></span>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
 </main>