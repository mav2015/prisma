<div class="flexcontainer-column" id="paymentsViewerContainer">
    <span class="">Métodos de pago <i class="fa-regular fa-credit-card"></i></span>
    
    <div class="top1 flexcontainer">
        <select id='businessUnitSelect'  class='nav__search--item'></select>
        <div id="paymentSearchBar"></div>
    </div>

    <select id="paymentviewerSelectContainer" class="select top maxwidth" multiple>
        <option class='centered' disabled> Busca un método de pago </option>
    </select>
</div> 

<script src="<?=asset('js/dashboard/payments.js')?>"></script>