<div class="container-fluid ">
    <div class=" col-md-4 offset-md-4 shadow bg-white my-4" style="padding: 50px 100px; border-radius: 40px">
        <div class="form-container d-flex flex-column ">
            <form class="d-flex row g-3 justify-content-center" method="post" enctype="multipart/form-data">
                <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>">
                <h1 class="text-center">Добавление диагноза</h1>
                <b class="text-center"><?= $message ?? ''; ?></b>
                <div class="col-12">
                    <label class="form-label ms-2">Название</label>
                    <input type="text" name="title" class=" form-control  rounded-pill ps-3 py-2">
                </div>
                <div class="col-12">
                    <label class="form-label ms-2">Описание</label>
                    <input type="text" name="description" class=" form-control  rounded-pill ps-3 py-2">
                </div>

                <input type="file" name="file">

                <div class="col-lg-12 d-flex justify-content-center" style="margin-top: 30px; a">
                    <button type="submit" class="btn btn-primary rounded-pill fs-5" style="padding: 10px 80px">
                        Записаться
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>