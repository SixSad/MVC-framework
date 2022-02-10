<h1 class="text-center">Список диагнозов</h1>
<div class="container">
    <section class="w-100 p-4 pb-4 d-flex justify-content-center align-items-center flex-column">

        <div>
            <form action="" method="get" class="d-flex">

                <input type="text" class="form-control rounded" placeholder="Диагноз" name="search">
                <button type="submit" class="btn btn-outline-primary">Найти</button>
            </form>
        </div>
    </section>
</div>
<div class="container mt-4">
    <?php
    use Src\Auth\Auth;
    $role = Auth::role() ;
    if(!empty($role)):
    if ($role ==3):
        ?>
        <button class="btn btn-primary mb-4" onclick="window.location.href='<?=app()->route->getUrl('/diagnosis/create')?>'">Создать</button>
    <?php
    endif;
    ?>
    <?php
    endif;
    ?>

    <table class="table  table-hover">
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col">Диагноз</th>
            <th scope="col">Описание</th>
            <th scope="col">Иллюстрация</th>
        </tr>
        </thead>
        <tbody >
        <?php
        $num=1;
        if(isset($diagnosis[0])){
            foreach ($diagnosis as $diagnose) {
                echo "<tr><th scope='row'>$num</th> <td>$diagnose->title</td> <td>$diagnose->description</td> <td><img width='200px' height='200px' src='".app()->settings->getRootPath()."$diagnose->image'></td> </tr>";
                $num++;
            }
        }
        else{
            echo "<h2 class='text-center text-secondary'>Таких записей нет</h2>";
        }
        ?>

        </tbody>
    </table>
</div>

