<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col col-md-9 col-lg-12 col-xl-8">
        <div class="card bg-light" style="border-radius: 15px;">
            <div class="card-body p-4 d-flex flex-column justify-content-center" style="height: 300px">
                <div class="d-flex text-black justify-content-between px-4">
                    <div class="d-flex">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-profiles/avatar-1.webp"
                             alt="Generic placeholder image" class="img-fluid"
                             style="width: 200px; border-radius: 10px;">
                        <div class="ms-4 ">
                            <h4 class="mb-2"><?= app()->auth::user()->firstname; ?></h4>
                            <h4 class="mb-1"><?= app()->auth::user()->lastname; ?></h4>
                            <?php
                            if (app()->auth::role()==3):
                            ?>
                            <h4 class="mt-5">Админ</h4>
                            <?php
                            elseif (app()->auth::role()==2):
                            ?>
                                <h4 class="mt-5">Доктор</h4>
                            <?php
                            else:
                            ?>
                            <h4 class="mt-5">Пациент</h4>
                            <?php
                            endif;
                            ?>

                        </div>
                    </div>

                    <div class="d-flex flex-column justify-content-between align-items-end">
                        <span class="rounded-circle"
                              style="background-color: lightgreen; height: 25px; width: 25px;"></span>
                        <div class="" style="margin-top: 30px;">
                            <button type="button" class="btn btn-outline-primary rounded-pill fs-5"
                                    onclick='window.location.href="<?= app()->route->getUrl('/logout') ?>"'
                                    style="padding: 10px 80px">Выйти
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
