<div class="flexcontainer-column" id="businessPartnersContainer">

    <span class="">Socio de negocio <i class="fa-solid fa-user"></i></span>

    <div class="flexcontainer">
        
            <div class="separated flex-wrap gap top1">
                <div>
                    <select id='searchBy' class='nav__search--item'>
                        <option value='federaltaxid'>D.N.I</option>
                        <option value='cardname'>Nombre</option>
                        <option value='cellular'>Celular</option>
                        <option value='cardcode'>Código</option>
                    </select>
                </div>
                <div id='searchBusinessPartnersContainer'></div>
            </div>
        
    </div>


    <select class="top maxwidth select" id="businessPartnersListContainer" multiple>
        <option disabled class='centered'>Busca un socio</option>
    </select>


</div>




<script src="<?= asset('js/businesspartners/functions.js') ?>"></script>
<script src="<?= asset('js/businesspartners/loadandlisteners.js') ?>"></script>