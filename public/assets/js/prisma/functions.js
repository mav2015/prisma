const itemsContainer = document.getElementById('itemscontainer')


//itemsContainer.innerHTML = 'Prueba...';
modal('transparentLoading');
getRequest(`/prisma/getdata/`)
.then( response => {
    modal(false);        
    let fragment = document.createDocumentFragment()
    let ind = 1;
    response.content.map(r => {
        
        if(r.AliasName != null && r.Street!= null){

        let item = document.createElement('div')
        item.setAttribute('class', 'gridtable st-highlight')
        item.innerHTML = ` <div class='gridtable__classic'>                
        
                <div class='gridtable__item'>
                    <div class='padd'>
                        ${ind}
                    </div>
                </div>
            
                <div class='gridtable__item'>
                    <div class='padd'>
                    ${r.BPLId}
                    </div>
                </div>

                <div class='gridtable__item'>
                    <div class='padd'>
                    ${r.AliasName}
                    </div>
                </div>

                <div class='gridtable__item'>
                    <div class='padd'>
                    ${r.Street}
                    </div>
                </div>
       </div>        
       `;
       fragment.appendChild(item);    
       ind++;
    }

    itemsContainer.appendChild(fragment);
});
});
