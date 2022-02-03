
<div class="container-fluid ">
    <div class=" col-md-4 offset-md-4 shadow bg-white my-4" style="padding: 50px 100px; border-radius: 40px">
        <div class="form-container d-flex flex-column ">
            <form class="d-flex row g-3" method="post">
                <h1  class="text-center">Запись на прием</h1>
                <b class="text-center text-danger"><?= $message ?? ''; ?></b>
                <div class="col-12">
                    <label class="form-label ms-2">Доктор</label>
                    <select class="form-control rounded-pill" id="exampleFormControlSelect1">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label ms-2">Выберите дату</label>
                    <input type="date" class=" form-control  rounded-pill ps-3 py-2" name="birth_date">
                </div>
                <div class="col-12 d-flex justify-content-center" style="margin-top: 30px; a">
                    <button type="submit" class="btn btn-primary rounded-pill fs-5" style="padding: 10px 80px">Записаться</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php