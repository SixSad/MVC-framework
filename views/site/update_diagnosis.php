<div class="container-fluid ">
    <div class=" col-md-4 offset-md-4 shadow bg-white  my-4" style="padding: 50px 100px;border-radius: 40px;">
        <div class="form-container d-flex flex-column ">
            <form class="row g-3" method="post">
                <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>">
                <h1 class="text-center">Постановка диагноза</h1>
                <b class="text-center text-danger"><?= $message ?? ''; ?></b>
                <div class="col-12">
                    <label class="form-label ms-2">Пациент</label>
                    <input type="text" class="form-control rounded-pill ps-3 py-2" name="username" disabled value="<?=$patient->firstname." ".$patient->lastname?>">
                </div>
                <div class="col-12">
                    <label class="form-label ms-2">Дата приема</label>
                    <input type="date" class=" form-control  rounded-pill ps-3 py-2" name="birth_date" value="<?=$form->date?>" disabled>
                </div>
                <div class="col-12">
                    <label class="form-label ms-2">Диагноз</label>
                    <select class="form-control rounded-pill" id="exampleFormControlSelect1" name='diagnosis'>
                        <?php
                        foreach ($diagnosis as $diag){
                            echo "<option value='$diag->id' >$diag->title</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-center" style="margin-top: 30px;">
                    <button type="submit" class="btn btn-primary rounded-pill fs-5" style="padding: 10px 80px">Подтвердить</button>
                </div>
            </form>
        </div>
    </div>
</div>

