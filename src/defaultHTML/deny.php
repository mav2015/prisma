<?php
    http_response_code(403);
    self::html(["title"=>"Error 403 acceso restringido"]);
?>

<?=self::body()?>

<div class="centered-column padd4">
    <img src="<?= asset('img/icons/tool.svg') ?>" width="30px">
    <h4>Permiso denegado.</h4> 
    <a href="<?=route()?>" title="Volver a la página principal">Pág. principal</a>
</div>

<?=self::end()?>