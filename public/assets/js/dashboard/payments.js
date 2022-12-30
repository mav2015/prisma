const paymentsViewerContainer = document.getElementById('paymentsViewerContainer')
const paymentviewerSelectContainer = document.getElementById('paymentviewerSelectContainer')
const paymentSearchBar = document.getElementById('paymentSearchBar')
const businessUnitSelect = document.getElementById('businessUnitSelect')


const [payments_searchForm, payments_searchInput] = navSearch(paymentSearchBar, null, false)


const searchPaymentsMethods = () => {

    modal('transparentLoading')

    getRequest(`/payments/getall/?search=${payments_searchInput.value}&division=${businessUnitSelect.value}`)
        .then(r => {
            modal(false)

            let methodFragment = document.createDocumentFragment()

            r.content.map(m => {
                let methodOption = document.createElement('option')
                methodOption.setAttribute('value', m.Code)
                methodOption.innerText = m.Name
                methodFragment.appendChild(methodOption)
            })

            paymentviewerSelectContainer.innerHTML = ''
            paymentviewerSelectContainer.appendChild(methodFragment)

        })
}


// Get business units
const userStorage = sStorage('USER')

if(userStorage.BusinessUnits){

    let fragment = document.createDocumentFragment()

    userStorage.BusinessUnits.map(r => {

        let option = document.createElement('option')
        option.setAttribute('value', r)
        option.innerText = r

        fragment.appendChild(option)
    })

    businessUnitSelect.appendChild(fragment)



}else{

    modal('transparentLoading')
    getRequest('/payments/acm/status')
    .then(response => {
        modal(false)
        let fragment = document.createDocumentFragment()
    
        if (response.status !== 200) return false;
        
        sStorage('USER',{
            ...userStorage,
            "BusinessUnits":response.content
        })


        response.content.map(r => {
    
            let option = document.createElement('option')
            option.setAttribute('value', r)
            option.innerText = r
    
            fragment.appendChild(option)
        })
    
        businessUnitSelect.appendChild(fragment)
    })

}


// listen to search submit
payments_searchForm.addEventListener('submit', ()=> searchPaymentsMethods())
businessUnitSelect.addEventListener('change', ()=> searchPaymentsMethods())