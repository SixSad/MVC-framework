

<?php
if (!app()->auth::check()):
    ?>
    <div class="container-fluid ">
        <div class=" col-md-4 offset-md-4 shadow bg-white my-4" style="padding: 50px 100px; border-radius: 40px">
            <div class="form-container d-flex flex-column ">
                <form class="d-flex row g-3" method="post">
                    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
                    <h1  class="text-center">Вход</h1>
                    <b class="text-center text-danger"><?= $message ?? ''; ?></b>
                    <div class="col-12">
                        <label class="form-label ms-2">Логин</label>
                        <input type="text" class="form-control rounded-pill ps-3 py-2" name="username" placeholder="login">
                    </div>
                    <div class="col-12">
                        <label class="form-label ms-2">Пароль</label>
                        <input type="password" class="form-control rounded-pill ps-3 py-2" name="password" placeholder="password">
                    </div>
                    <div class="col-12 d-flex justify-content-center" style="margin-top: 30px; a">
                        <button type="submit" class="btn btn-primary rounded-pill fs-5" style="padding: 10px 80px">Log In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif;