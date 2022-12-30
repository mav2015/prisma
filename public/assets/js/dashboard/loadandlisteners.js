//Restore data on refresh page

GLOBAL.priceList = pricesList.value

if (Object.keys(GLOBAL.cartList).length === 0 && Object.keys(sStorage('productsOnCart')).length > 0) {
    GLOBAL.cartList = sStorage('productsOnCart')
}

setBoardNavigation()

// Listeners 
showProductsOnBoard.addEventListener('click',()=>{
    GLOBAL.boardPosition = 'products'
    setBoardNavigation()
})

showBillingOnBoard.addEventListener('click',()=>{
    GLOBAL.boardPosition = 'billing'
    setBoardNavigation()
})

showShippingOnBoard.addEventListener('click',()=>{
    GLOBAL.boardPosition = 'shipping'
    setBoardNavigation()
})


productviewerSelectContainer.addEventListener('dblclick',e=>{
    if(e.target.dataset.type === 'select'){
        addProductOnList(JSON.parse(e.target.dataset.data))
    }
})

productsBoardTrashButton.addEventListener('click',()=>{
    confirmation('Seguro/a que quieres limpiar la lista del carrito ?', ()=>{
        cleanCartList()
    })
})

pricesList.addEventListener('change',e=>{

    GLOBAL.priceList = e.target.value

    if(GLOBAL.boardPosition === 'products') listProductsOnBoard()
})

boardContentContainer.addEventListener('click',e=>{
    if(e.target.dataset.type === 'removeButton'){
        removeItemFromList(e.target.dataset.code)
    }
})

boardContentContainer.addEventListener('change',e=>{
    
    if(e.target.dataset.type === 'countInput'){
        changeItemCountFromList(e.target.dataset.code,e.target.value)
    }
})
    
