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

    // add Financieras
    let option2 = document.createElement('option')
    option2.setAttribute('value','Financieras')
    option2.innerText = 'Financieras'
    fragment.appendChild(option2)

    businessUnitSelect.appendChild(fragment)
    


}else{

    modal('transparentLoading')    
    getRequest('/payments/getbusinessunits')
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

        // add Financieras
        let option2 = document.createElement('option')
        option2.setAttribute('value','Financieras')
        option2.innerText = 'Financieras'
        fragment.appendChild(option2)
    
        businessUnitSelect.appendChild(fragment)
    })

}






searchForm.addEventListener('submit', search)
businessUnitSelect.addEventListener('change', search)
search()


// change surcharge alert
itemsContainer.addEventListener('change', e=>{

    if(e.target.dataset.type === 'surcharge') checkInput(e.target) 
})




// Edit listener
itemsContainer.addEventListener('click',e=>{

    // edit user
    if(e.target.dataset.type !== 'editButton' && e.target.dataset.type !== 'enable') return 
    
    const code = e.target.dataset.code
    let postData = {}
    postData['Code'] = code
    const surcharge = document.getElementById(`U_Surcharge_${code}`)

    // checkInput
    if (e.target.dataset.type === 'enable') {

        postData['Canceled'] = e.target.checked ? 'N' : 'Y'
    }else{
        
        postData['U_Surcharge'] = surcharge.value
    }

    // postData['U_Quotas'] = event.target.U_Quotas.value
    // postData['Name'] = event.target.Name.value

    modal('transparentLoading')
    postRequest(`/payments/savepaymentedit/`,JSON.stringify(postData))
    .then(r=>{
        modal(false) 

        if(r.status !== 200){
            mssg(r.message, 'e')
            return false;
        }

        // Change initial state and check to remove input alert
        surcharge.dataset.initial = surcharge.value
        checkInput(surcharge)
        
        mssg(r.message)
    })

})



// listen to new payment button
newButton.addEventListener('click',()=>{
    
    const modalContainer = modal()
    const newTemplate = newPaymentTemplate()

    modalContainer.appendChild(newTemplate)

    
    
    newTemplate.addEventListener('submit',e=>{
        e.preventDefault()

        let data = {}
        data['EntityType'] = e.target.EntityType.value
        data['EntityName'] = e.target.EntitySelector.value
        data['Description'] = e.target.Description.value
        data['Quota'] = e.target.Quota.value
        data['Interest'] = e.target.Interest.value
        data['Division'] = businessUnitSelect.value

        postRequest('/payments/createnewpayment/',JSON.stringify(data))
        .then(r=>{
            mssg(r.message, r.status !== 200 && ('e') )
            r.status === 200 && modal(false)
        })

    })



    let searching = false;
    let timmer = ()=>{
        searching = true;
        setTimeout(
            ()=>{
            searchEntity(newTemplate)
            searching = false
        }
        ,1000)
    }
        
    
    newTemplate.EntityName.addEventListener('keyup', e=>{
        
        if(!searching) timmer()       
        
        fillExample(newTemplate)
    })


    newTemplate.EntityType.addEventListener('change',r=>{
        searchEntity(newTemplate)
        fillExample(newTemplate)
    })

    newTemplate.addEventListener('keyup', ()=>fillExample(newTemplate))
    newTemplate.addEventListener('change', ()=>fillExample(newTemplate))
    newTemplate.EntitySelector.addEventListener('click', ()=>fillExample(newTemplate))

})