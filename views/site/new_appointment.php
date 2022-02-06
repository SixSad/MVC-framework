<div class="container-fluid ">
    <div class=" col-md-4 offset-md-4 shadow bg-white my-4" style="padding: 50px 100px; border-radius: 40px">
        <div class="form-container d-flex flex-column ">
            <form class="d-flex row g-3 justify-content-center" method="post">
                <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>">
                <h1 class="text-center">Запись на прием</h1>
                <b class="text-center"><?= $message ?? ''; ?></b>
                <div class="col-12">
                    <label class="form-label ms-2">Доктор</label>
                    <select class="form-control rounded-pill" id="exampleFormControlSelect1" name="doctor_id">
                        <?php
                        foreach ($doctors as $doctor){
                            echo "<option value='$doctor->id'>$doctor->firstname $doctor->lastname</option>";
                        }
                        ?>
                    </select>
                </div>
                <input name="patient_id" type="hidden" value="<?= app()->auth::user()->id; ?>"
                <div class="col-12">
                    <label class="form-label ms-2">Выберите дату</label>
                    <input type="date" class=" form-control  rounded-pill ps-3 py-2" name="date">
                </div>

                <div class="col-lg-12 d-flex justify-content-center" style="margin-top: 30px; a">
                    <button type="submit" class="btn btn-primary rounded-pill fs-5" style="padding: 10px 80px">
                        Записаться
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php