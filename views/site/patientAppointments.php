<h1 class="text-center">Записи на прием</h1>
<div class="container">
    <section class="w-100 p-4 pb-4 d-flex justify-content-center align-items-center flex-column">
        <div>
            <div class="input-group">
                <input type="search" class="form-control rounded" placeholder="Доктор" aria-label="Search"
                       aria-describedby="search-addon">
                <input type="date" class="form-control rounded" placeholder="Диагноз" aria-label="Search"
                       aria-describedby="search-addon">
                <button type="button" class="btn btn-outline-primary" style="">Найти</button>
            </div>
        </div>
    </section>
    <div class="container mt-4">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Врач</th>
                <th scope="col">Время</th>
            </tr>
            </thead>
            <tbody>
            <?php

            foreach ($appointments as $appointment) {
                echo '<tr><th scope="row">' . $appointment->id . '</th> <td>' . $appointment->patient_id . '</td> <td>' . $appointment->date . '</td>        </tr>';

            }
            ?>

            </tbody>
        </table>
    </div>
</div>