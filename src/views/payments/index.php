<?php
self::html();

//use core\session;
?>

<link rel="stylesheet" href="<?= asset('css/gridtable.css') ?>">
<?= self::body() ?>

<div class="padd1">

    <h3>Metodos de Pagos</h3>

    <div class="flexcontainer flex-column padd1">
        <nav id='navContainer' class='separated flex-wrap st-lowlight radius'>

            <div class="flexcontainer flex-wrap">
                <select id="businessUnitSelect" class='nav__search--item st-highlight'>
                </select>
                <div id="searchContainer"></div>
            </div>

            <div class="padd">
                <button id="newButton" class="pointer st-classic">Nuevo</button>
            </div>
        </nav>

        <div class="top2">
            <div class="gridtable__container">
                <div class='gridtable__header'>
                <div class='gridtable__header--item grid-fill2'><div class='padd'>Nombre / Código</div></div>
                <div class='gridtable__header--item'>Cuotas</div>
                <div class='gridtable__header--item'>Interés</div>
                <div class='gridtable__header--item'>Opciones</div>
                </div>            
            </div>
            <div class="gridtable__container" id="itemscontainer"></div>
        </div>
    </div>
</div>



<script src="<?= asset('js/payments/functions.js') ?>"></script>
<script src="<?= asset('js/payments/loadandlisteners.js') ?>"></script>
<?= self::end() ?>