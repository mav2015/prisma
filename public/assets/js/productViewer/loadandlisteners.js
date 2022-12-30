
const productsUnits = sStorage('USER')

if(productsUnits.BusinessUnits){

    let fragment = document.createDocumentFragment()

    productsUnits.BusinessUnits.map(r => {

        let option = document.createElement('option')
        option.setAttribute('value', r)
        option.innerText = r

        fragment.appendChild(option)
    })

    productBusinessUnitSelect.appendChild(fragment)
}

productBusinessUnitSelect.addEventListener('change',()=>searchProducts())
pV_searchForm.addEventListener('submit',()=>searchProducts())