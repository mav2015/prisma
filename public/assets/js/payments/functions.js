const itemsContainer = document.getElementById('itemscontainer')
const searchContainer = document.getElementById('searchContainer')
const businessUnitSelect = document.getElementById('businessUnitSelect')
const newButton = document.getElementById('newButton')

const [searchForm, searchInput] = navSearch(searchContainer)



const search = () => {

    modal('transparentLoading')
    getRequest(`/payments/getall/?search=${searchInput.value}&division=${businessUnitSelect.value}`)
        .then(r => {

            modal(false)
            itemsContainer.innerHTML = ''

            let fragment = document.createDocumentFragment()

            if(r.content.length === 0){

                let item = document.createElement('div')
                item.setAttribute('class', 'gridtable__classic')
                item.innerHTML = `                
                <div class='centered flex-wrap'>
                    <div class='padd b'>
                        <label class='gridtable__item--label'>&nbsp;</label>
                        <span class='b fs1-3'>No se encontraron coincidencias</span>
                    </div>
                </div>`

                fragment.appendChild(item)
                
            }else{
                    r.content.map(response => {

                    let item = document.createElement('div')
                    item.setAttribute('class', 'gridtable st-highlight')

                    item.innerHTML = `                
                        <div class='gridtable__item separated flex-wrap  grid-fill2'>
                            <div>
                                <label class='gridtable__item--label'>Nombre</label>
                                <span class='b'>${response.Name}</span>
                            </div>
                            <div>
                                <label class='gridtable__item--label'>Código</label>
                                <span class='b'>${response.Code}</span>
                            </div>
                        </div>
                        
                        <div class='gridtable__item flexcontainer'>
                            <div class=''>
                                <label class='gridtable__item--label'>Cuotas</label>
                                <span class='b'>${response.U_Quotas}</span>
                            </div>
                        </div>

                        <div class='gridtable__item flexcontainer'>
                            <div class=''>
                                <label class='gridtable__item--label'>Interés</label>
                                <input id="U_Surcharge_${response.Code}" type='number' step='0.0001' min='0' class='b large' data-type='surcharge' data-initial="${response.U_Surcharge}" value="${response.U_Surcharge}">
                            </div>
                        </div>
                        
                        <div class='gridtable__item--structured separated'>                
                            <button class='gridtable__item--button' data-code="${response.Code}" data-type='editButton'>Guardar Cambios</button>
                            <div class=''>
                                <label class='gridtable__item--label'>Activo</label>
                                <label class="switch">
                                    <input type="checkbox" ${response.Canceled === 'N' ? 'checked' : ''} data-code="${response.Code}" data-type="enable">
                                    <span class="slider round"></span>
                                </label>
                            </div>

                        </div>
                    `

                    fragment.appendChild(item)
                })
                
            }

            itemsContainer.appendChild(fragment)
        })
}






const newPaymentTemplate = () => {

    const container = document.createElement('form')
    container.setAttribute('class', 'centered')
    container.setAttribute('autocomplete','off')


    container.innerHTML = `<div class='card st-classic'>

    <div class='top1 b fs'>Entidad</div>
    
    <div class='st-lowlight padd1 radius top'>

        <div class="separated flex-wrap gap2">
            <div>        
                <label class='card__item--label'>Tipo Entidad</label>
                <select id='EntityType'>
                    <option value='Tarjeta'>Tarjeta</option>
                    <option value='Financiera'>Financiera</option>
                </select>
            </div>
            <div>
                <label class='card__item--label'>Buscar/Crear Entidad</label>
                <input type='text' id='EntityName' class='card__item b fs1-3' placeholder="Visa / Mastercard">
            </div>
        </div>


        <div class="card__section">
            <select class="maxwidth" id='EntitySelector' multiple required>
            </select>
        </div>
    </div>
    

    <div class='top1 b fs'>Plan de pago</div>
    
    <div class='st-lowlight padd radius top'>
        <div class="card__section">
            <label class='card__item--label'>Descripción adicional</label>
            <input type='text' id='Description' class='card__item b fs1-3' placeholder="Z / Ahora">
        </div>

        <div class='separated flex-wrap gap top padd'>
            <div>
                <label class='card__item--label'>Cuotas</label>
                <input type="number" min='1' step='1' value='1' class='card__item b large' id='Quota' placeholder="18/12" required>
            </div>

            <div>
                <label class='card__item--label'>Interés</label>
                <input type="number" min='0' step='0.0001' value='0' class='card__item b large' id='Interest' placeholder="15,25" required>
            </div>
        </div>
    </div>


    <div class='top1 b fs'>Resultado Final</div>
    
    <div class='card__section'>
        <span class='b st-normal centered' id='FullName'> -- </span>
    </div>


    <div class='separated top2 gap'>
        <button class='st-fine pointer' data-type='saveButton'>Crear plan</button>
        <button class='st-danger pointer' onclick="modal(false)">Cancelar</button>
    </div>
    </div>
`
    return container
}



const searchEntity = (newTemplate)=>{



    const data = {}
            
    data["division"] = businessUnitSelect.value
    data["type"] = newTemplate.EntityType.value
    data["name"] = capitalize(newTemplate.EntityName.value)

    newTemplate.EntitySelector.innerHTML='<option>Buscando entidad aguarde...</option>'

    postRequest('/payments/findentity/',JSON.stringify(data))
    .then(r=>{

        let fragment = document.createDocumentFragment()

        if(r.content.length > 0){

            r.content.map(ob=>{
                let optionValue = `${ob.Name.split(' ').slice(1, -1).join(' ')};${ob.Code}`

                let item =  document.createElement('option')
                item.setAttribute('value',optionValue)
                item.innerText = ob.Name
                fragment.appendChild(item)
            })
        }else{

            newTemplate.EntitySelector.value = data["name"]
            let item =  document.createElement('option')
            item.setAttribute('selected',true)
            item.setAttribute('value',`${data["name"]};NewEntity`)
            item.innerHTML = `<span class='st-warning radius'>&nbsp; Nueva &nbsp;</span> ${data["name"]}`
            fragment.appendChild(item)

        }

        newTemplate.EntitySelector.innerHTML=''
        newTemplate.EntitySelector.appendChild(fragment)
        
    })
}




const checkInput = (item)=>{
    if(item.dataset.initial !== item.value){
        item.classList.remove('st-warning')
        item.classList.add('st-warning')
    }else{
        item.classList.remove('st-warning')
    }
}



const fillExample = (newTemplate)=>{

    let entityselected = newTemplate.EntitySelector.value.split(';').slice(0,-1)
    
    const interest = newTemplate.Interest.value == 0 ? 'Sin Interes':''

    document.getElementById('FullName').innerText = `${newTemplate.EntityType.value} ${entityselected} ${capitalize(newTemplate.Description.value)} ${newTemplate.Quota.value} ${interest}`
}