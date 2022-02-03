<h1 class="text-center">Список диагнозов</h1>
<div class="container">
    <section class="w-100 p-4 pb-4 d-flex justify-content-center align-items-center flex-column">
        <div>
            <div class="input-group">
                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                       aria-describedby="search-addon">
                <button type="button" class="btn btn-outline-primary" style="">search</button>
            </div>
        </div>
    </section>
</div>
<div class="container mt-4">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Диагноз</th>
            <th scope="col">Описание</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($diagnosis as $diagnose) {
            echo '<tr><th scope="row">' . $diagnose->id . '</th> <td>' . $diagnose->title . '</td> <td>' . $diagnose->description . '</td>        </tr>';

        }
        ?>

        </tbody>
    </table>
</div>

