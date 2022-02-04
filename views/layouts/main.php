
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <title>Pop it MVC</title>
</head>
<body>
<div class="container-fluid p-0 mw-100">
    <header class=" d-flex  flex-column flex-md-row align-items-center justify-content-center justify-content-md-between py-3 shadow bg-white rounded "
            style="padding: 0px 100px;">

        <div class="d-flex flex-row">
            <h2><a href="<?= app()->route->getUrl('/') ?>"
                   class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none a ">
                    ЦСМ
                </a></h2>
            <div class="dropdown ms-4">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                        aria-expanded="false">
                    Услуги
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                    <?php
                    if (app()->auth::role() == 3):
                        ?>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/appointments/create') ?>">Записаться
                                на прием</a></li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/appointments') ?>">Записи на
                                прием</a></li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/diagnosis') ?>">Дигнозы</a></li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/create_user') ?>">Создать
                                пользователя</a></li>
                    <?php
                    elseif (app()->auth::role() == 2):
                        ?>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/appointments') ?>">Записи на
                                прием</a></li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/diagnosis') ?>">Дигнозы</a></li>
                    <?php
                    elseif (app()->auth::role() == 1):
                        ?>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/appointments/create') ?>">Записаться
                                на прием</a></li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/appointments') ?>">Ваши записи</a></li>

                    <?php
                    else:
                        ?>
                        <li><a class="dropdown-item" href="#">Цены</a></li>
                        <li><a class="dropdown-item" href="#">О нас</a></li>
                        <li><a class="dropdown-item" href="#">Контакты</a></li>
                    <?php
                    endif;
                    ?>

                </ul>
            </div>


        </div>

        <div class=" d-flex">
            <?php
            if (!app()->auth::check()):
                ?>
                <button type="button" class="btn btn-outline-primary me-2"
                        onclick='window.location.href="<?= app()->route->getUrl('/login') ?>"'>Login
                </button>
                <button type="button" class="btn btn-primary"
                        onclick='window.location.href="<?= app()->route->getUrl('/signup') ?>"'>Sign-up
                </button>
            <?php
            else:
                ?>
                <div class="dropdown ms-4">
                    <a href="#" class="d-block link-dark  dropdown-toggle fs-3" id="dropdownUser1"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <?= app()->auth::user()->firstname; ?>
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/profile') ?>">Профиль</a></li>
                        <li><a class="dropdown-item" href="<?= app()->route->getUrl('/logout') ?>">Выйти</a></li>
                    </ul>
                </div>
            <?php
            endif;
            ?>

        </div>
    </header>

    <main class="pt-5" style="margin: 0px 100px;">
        <?= $content ?? '' ?>
    </main>


</div>
<footer class=" fixed-bottom bg-dark ">
    <div class="" style="max-height:200px;min-height: 50px">
    </div>
</footer>
</body>
</html>
