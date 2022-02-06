<h1 class="text-center">Записи на прием</h1>
<div class="container d-flex justify-content-center mt-5">
    <form action="" method="get" class="d-flex col-6">
        <input type="text" class="form-control rounded" placeholder="Пациент" name="search_patient">
        <input type="date" name="search_date">
        <button type="submit" class="btn btn-outline-primary">Найти</button>
    </form>
</div>
<div class="container mt-4">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col">Пациент</th>
            <th scope="col">Время</th>
        </tr>
        </thead>
        <tbody>

        <?php
        if(!empty($appointments)&&isset($appointments[0])){
            $number = 1;
            foreach ($appointments as $appointment) {
                echo '<tr><th scope="row">' . $number . '</th> <td>' . $appointment->patient_id . '</td> <td>' . $appointment->date . '</td>        </tr>';
                $number++;
            }
        }
        else{
            echo "<h2 class='text-center text-secondary'>Таких записей не существует</h2>";
        }
        ?>


        </tbody>
    </table>
</div>