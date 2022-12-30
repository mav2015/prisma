<?php
    http_response_code(404);
    self::html(["title"=>"Error 404 Página no encontrada"]);
?>

<?=self::body()?>

<div class="centered-column padd4">
    <img src="<?= asset('img/icons/tool.svg') ?>" width="30px">
    <h4>ERROR 404. No se encontró la página.</h4> 
    <a href="<?=route()?>" title="Volver a la página principal">Pág. principal</a>
</div>

<?=self::end()?>