const searchBy = document.getElementById('searchBy')
const listContainer = document.getElementById('businessPartnersListContainer')
const searchPartnersContainer = document.getElementById('searchBusinessPartnersContainer')

    const [partnerSearchForm,partnerSearchInput] = navSearch(searchPartnersContainer,null,false)



const partnerTemplate = (data) => {

    let fragment = document.createDocumentFragment()

    data.map(r => {

        let item = document.createElement('option')
        item.setAttribute('value', JSON.stringify(r))

        let frozen = false

        if (r.Frozen === 'tYES' || r.Valid === 'tNO') {
            frozen = true
        }

        item.innerHTML=`${r.CardName} - ${r.FederalTaxID}`

        fragment.appendChild(item)
    })

    listContainer.innerHTML=''
    listContainer.appendChild(fragment)
}


const newPartnerTemplate = (field, value) => {

    let item = document.createElement('form')
    item.setAttribute('class', 'centered')

    item.innerHTML = `
    <div class='st-classic card gap padd2'>

        <div class='card__description padd fs1-5'>
            Crear Nuevo Socio <i class="fa-solid fa-user"></i>
        </div>

        <div class='separated flex-wrap gap top1 st-lowlight padd'>
            <div class=''>
                <label class='card__item--label'>Apellido</label>
                <input type='text' id='LastName' class='card__item' required>
            </div>

            <div class=''>
                <label class='card__item--label'>Nombre</label>
                <input type='text' id='Name' class='card__item' value="${field === 'cardname' ? value : ''}" required>
            </div>
        </div>

        <div class='separated flex-wrap gap top1 st-lowlight padd'>
            <div class=''>
                <label class='card__item--label'>Tipo</label>
                <select id='VATCtg'>
                    <option value='CF'>Consumidor Final</option>
                    <option value='RI'>Responsable Insc.</option>
                    <option value='EX'>Exento</option>
                </select>
            </div>

            <div class=''>
                <label class='card__item--label'>DNI/CUIT</label>
                <input type='text' id='FederalTaxID' class='card__item' value="${field === 'federaltaxid' ? value.replace(/ /g, "") : ''}" required>
            </div>
        </div>


        <div class='separated flex-wrap gap top1 st-lowlight padd'>
            <div class='padd'>
                <label class='card-description'>Teléfono Fijo</label>

                <label class='card__item--label'>Teléfono</label>
                <input type='text' id='Phone1' class='card__item'>
            </div>

            <div class='st-highlight padd'>
                <label class='card-description'>Celular</label>
                <div class='separated top'>
                    <div>
                        <label class='card__item--label'>Cód.Area</label>
                        <input type='tel' id='areaCode' class='card__item medium' placeholder='123'>
                    </div>
                    <div>
                        <div class='b st-disabled top1 padd'>15</div>
                    </div>
                    <div>
                        <label class='card__item--label'>Número</label>
                        <input type='tel' id='cellBody' class='card__item large' placeholder='4567890'>
                    </div>
                </div>

            </div>

        </div>
        
        <div class='card__section top1 st-lowlight padd'>

        </div>

        <div class='separated flex-wrap gap top1 st-lowlight padd'>
            <div class=''>
                <label class='card__item--label'>Localidad</label>
                <input type='text' id='City' class='card__item'>
            </div>
            <div class=''>
                <label class='card__item--label'>Domicilio</label>
                <input type='text' id='Address' class='card__item'>
            </div>
        </div>

        <div class='card__section top1 st-lowlight padd'>
            <label class='card__item--label'>Email</label>
            <input type='email' id='EmailAddress' class='card__item'>
        </div>

        <div class='separated flex-wrap gap top1 padd'>
            <input type='submit' id='createButton' data-loading='false' class='st-fine' value='Crear socio'>
            <input type='button' class='st-danger' value='Cancelar' onclick="modal(false)">
        </div>
    </div>`

    modal().appendChild(item)

    return item
}


const createNewPartner = (data,loadingButton) => {

    loadingButton.dataset.loading = true
    loadingButton.value='Cargando...'
    
    postRequest(`/businesspartners/createnewuser/`, JSON.stringify(data))
        .then(r => {


            loadingButton.dataset.loading = false
            loadingButton.value='Crear socio'

            mssg(r.message, r.status !== 200 && ('e'))
            r.status === 200 && modal(false)

            // search()
            if (r.content !== false) {
                searchPartner('cardcode', r.content)
                return false;
            }
        })
}


const searchPartner = (by, value) => {
    // loading...
    modal('transparentLoading')

    // request
    getRequest(`/businesspartners/getall?${by}=${value}`)
        .then(r => {
            modal(false)

            // If some error
            if (r.status !== 200 || r.content[0] !== 200) {
                modal(false)
                return mssg('Error en la consulta', 'e')
            }

            // Loading data
            const response = r.content[1].value


            // to new business partner
            if (response.length === 0) {

                const newPartnerForm = newPartnerTemplate(by, value)

                newPartnerForm.addEventListener('submit', e => {
                    e.preventDefault()

                    data = {}

                    data['LastName'] = e.target.LastName.value
                    data['Name'] = e.target.Name.value
                    data['VATCtg'] = e.target.VATCtg.value
                    data['FederalTaxID'] = e.target.FederalTaxID.value
                    data['Phone1'] = e.target.Phone1.value
                    data['Cellular'] = `${e.target.areaCode.value}${e.target.cellBody.value}`
                    data['City'] = e.target.City.value
                    data['Address'] = e.target.Address.value
                    data['EmailAddress'] = e.target.EmailAddress.value

                    if(newPartnerForm.createButton.dataset.loading === 'false') createNewPartner(data,newPartnerForm.createButton)
                })

                return false;
            }



            // show partners
            partnerTemplate(response)
        })

}