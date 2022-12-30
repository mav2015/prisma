<div class="flexcontainer-column" id="productViewerContainer">
    <span class="">Productos <i class="fa-solid fa-boxes-stacked"></i></span>
    
    <div class='flexcontainer top1'>
        <select id='productBusinessUnitSelect'  class='nav__search--item'></select>
        <div id="productViewerSearchBarContainer" class=""></div>
    </div>

    <select id="productviewerSelectContainer" class="select maxwidth top" multiple>
        <option class='centered' disabled> Busca un producto </option>
    </select>
</div> 

<script src="<?= asset('js/productViewer/functions.js')?>"></script>
<script src="<?= asset('js/productViewer/loadandlisteners.js')?>"></script>