<h1 class="text-center">Записи на прием</h1>
<?php
foreach ($appointments as $diagnose) {
    echo '<li>' . $diagnose->doctor_id. " " . $diagnose->date. '</li>';
}
?>
