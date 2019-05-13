<main>
    <?= $nav; ?>
    <?php if (empty($is_auth[0]['name'])) : print_r($is_auth); ?>
        <form class="form container <?= $errors ? 'form--invalid' : ''; ?>" action="login.php" method="post" enctype="multipart/form-data">
            <h2>Вход</h2>
            <div class="form__item <?= !empty($errors['email']) ? 'form__item--invalid' : ''; ?>">
                <label for="email">E-mail <sup>*</sup></label>
                <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $post['email'] ?? ''; ?>">
                <span class="form__error"><?= $errors['email']; ?></span>
            </div>
            <div class="form__item form__item--last <?= !empty($errors['password']) || $errors ? 'form__item--invalid' : ''; ?>">
                <label for="password">Пароль <sup>*</sup></label>
                <input id="password" type="password" name="password" placeholder="Введите пароль">
                <span class="form__error"><?= $errors['password']; ?></span>
            </div>
            <button type="submit" class="button">Войти</button>
        </form>
    <?php else : print($is_auth[0]['name'] . ' Вы уже вошли на сайт, если желаете авторизоваться используя другую учетную запись - выйдете из текущей');
    endif; ?>

</main>