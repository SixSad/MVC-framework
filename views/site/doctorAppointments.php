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
            <th scope="col">Дата</th>
            <th scope="col">Диагноз</th>
        </tr>
        </thead>
        <tbody>
        <?php
        use Model\User;
        use Model\Diagnosis;
        if (!empty($appointments) && isset($appointments[0])) {
            $number = 1;
            foreach ($appointments as $appointment) {
                $user = User::where('id', $appointment->patient_id)->first();
                if (!empty($appointment->diagnosis)) {
                    $diagnosis = Diagnosis::where('id', $appointment->diagnosis)->first()['title'];
                    echo '<tr><th scope="row">' . $number . '</th> <td>' . $user->firstname .  $user->lastname . '</td> <td>' . $appointment->date . '</td><td>' . $diagnosis . '</td></tr>';
                    $number++;
                }
                else{
                    $url = app()->route->getUrl("/diagnosis/update?id=$appointment->id");
                    echo "<tr><th scope='row'>$number</th> <td>$user->firstname $user->lastname</td> <td>$appointment->date</td><td><a class='btn btn-primary' href='$url'>Добавить</a></td></tr>";
                    $number++;
                }
            }
        } else {
            echo "<h2 class='text-center text-secondary'>Таких записей не существует</h2>";
        }
        ?>


        </tbody>
    </table>
</div>