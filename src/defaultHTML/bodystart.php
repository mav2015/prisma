<?php // bodystart default file 

use src\models\menuModel;

?>

<div id="alertBox" class="alertbox__container"></div><script src="<?=asset('js/alert.js')?>"></script>

<div id="modalcontainer" class="modal__container modal__hide">
	<button id='modalclose' class='modal__close' title='Cerrar'>x</button>
	<div id="modal" class="modal"></div>
</div><script src="<?=asset('js/modals.js')?>"></script>




<header class="main__header">

    <a href="<?=route()?>"><h1 class="main__header--title"><?=GENERAL['sitename']?> <i class="fa-solid fa-dungeon"></i></h1></a>

    <div id='main__menu--hamburger' class='main__menu--hamburger'>
        <div class="main__menu--hamburger-raw"></div>
        <div class="main__menu--hamburger-raw"></div>
        <div class="main__menu--hamburger-raw"></div>
    </div>    
    <nav id='main__menu' class='main__menu'>
        <ul id='main__ul'></ul>
    </nav>
    
    <script src="<?=asset('js/menu.js')?>"></script>

</header>


<main class="main__content">





