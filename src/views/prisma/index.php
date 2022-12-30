<?=self::html()?>

<?=self::body()?>

<div class="padd1">

    <h3>Seleccionar Sucural</h3>

    <div class="flexcontainer flex-column padd1">

        <div class="top2">
            <div class="gridtable__container">
                <div class='gridtable__header'>       
                <div class='gridtable__header--item'>#</div>             
                <div class='gridtable__header--item'>Codigo</div>
                <div class='gridtable__header--item'>Sucursal</div>
                <div class='gridtable__header--item'>Direccion</div>
                </div>            
            </div>
            <div class="gridtable__container" id="itemscontainer"></div>
        </div>
    </div>
</div>

<script src="<?= asset('js/prisma/functions.js') ?>"></script>

<?=self::end()?>

