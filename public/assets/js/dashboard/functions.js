const boardTitle = document.getElementById('boardTitle')
const productsSelectorContainer = document.getElementById('productsSelectorContainer')
const partnersSelectorContainer = document.getElementById('partnersSelectorContainer')
const paymentsSelectorContainer = document.getElementById('paymentsSelectorContainer')

const showProductsOnBoard = document.getElementById('showProductsOnBoard')
const showBillingOnBoard = document.getElementById('showBillingOnBoard')
const showShippingOnBoard = document.getElementById('showShippingOnBoard')

const boardContentContainer = document.getElementById('boardContentContainer')

const productsBoardTrashButton = document.getElementById('productsBoardTrashButton')

const pricesList = document.getElementById('pricesList')



// check board Position then display and hidde elements
const setBoardNavigation = () => {
    boardTitle.innerHTML = boardTitles[GLOBAL.boardPosition]
    boardContentContainer.innerHTML = ''

    if (GLOBAL.boardPosition === 'products') {
        productsBoardTrashButton.style.display = 'block'
        productsSelectorContainer.style.display = 'block'
        partnersSelectorContainer.style.display = 'none'
        paymentsSelectorContainer.style.display = 'none'
        listProductsOnBoard()
    }
    else if (GLOBAL.boardPosition === 'billing') {
        productsBoardTrashButton.style.display = 'none'
        productsSelectorContainer.style.display = 'none'
        partnersSelectorContainer.style.display = 'block'
        paymentsSelectorContainer.style.display = 'block'
    }
    else if (GLOBAL.boardPosition === 'shipping') {
        productsBoardTrashButton.style.display = 'none'
        productsSelectorContainer.style.display = 'none'
        partnersSelectorContainer.style.display = 'none'
        paymentsSelectorContainer.style.display = 'none'
    }
}




const addProductOnList = (data) => {

    // restore list from session storage
    if (Object.keys(GLOBAL.cartList).length === 0 && Object.keys(sStorage('productsOnCart')).length > 0) {
        GLOBAL.cartList = sStorage('productsOnCart')
    }

    // insert item
    const code = data.ItemCode

    if (GLOBAL.cartList[code]) {
        GLOBAL.cartList[code].itemCount = GLOBAL.cartList[code].itemCount + 1
    } else {
        GLOBAL.cartList[code] = { "itemCount": 1, ...data }
    }


    sStorage('productsOnCart', GLOBAL.cartList)

    listProductsOnBoard()

    mssg('Producto agregado al carrito')
}



const cleanCartList = () => {
    GLOBAL.cartList = {}
    sStorage('productsOnCart', {})

    listProductsOnBoard()

    mssg('Se limpio la lista del carrito', 'e')
}


const removeItemFromList = (itemCode) => {
    data = GLOBAL.cartList
       
    delete data[itemCode]

    sStorage('productsOnCart', data)


    listProductsOnBoard()
}



const changeItemCountFromList = (item,value) =>{
    data = GLOBAL.cartList
       
    data[item]['itemCount'] = value

    sStorage('productsOnCart', data)

    listProductsOnBoard()
}


// check if products exists in list and print on screen
const listProductsOnBoard = () => {

    boardContentContainer.innerHTML = `
        <div class='gridtable__header'>
        <div class='gridtable__item centered b'>Código</div>
        <div class='gridtable__item centered b grid-fill4'>Descripción</div>
        <div class='gridtable__item centered b'>P. Unidad</div>
        <div class='gridtable__item centered b'>Cantidad</div>
        <div class='gridtable__item centered b'>P. Final</div>
        </div>`


    let realList = sStorage('productsOnCart') ? sStorage('productsOnCart') : GLOBAL.cartList;

    // check if list is empty
    if (Object.keys(realList).length === 0) {
        let item = document.createElement('div')
        item.setAttribute('class', 'gridtable fs1-5 st-lowlight')
        item.innerHTML = '<div class="centered gridtable__item ">Agrega productos al carrito</div>'
        boardContentContainer.appendChild(item)
    } 

    // if list is not empty
    else {

        let fragment = document.createDocumentFragment()

        let total = 0

        for (const obj in realList) {
            let item = document.createElement('div')
            item.setAttribute('class', 'gridtable')

            dataItem = realList[obj]

            let price = parseFloat(dataItem.ItemPrices[GLOBAL.priceList].Price)

            let iva = parseFloat(dataItem.ArTaxCode.split("_")[1])

            let unitPrice = ((price * iva) / 100) + price

            let finalPrice =  unitPrice * dataItem.itemCount

            let currency = dataItem.ItemPrices[GLOBAL.priceList].Currency

            currency = currency !== null ? dataItem.ItemPrices[GLOBAL.priceList].Currency : '';

            total+=finalPrice

            item.innerHTML = `
            <div class='gridtable__item around'>
                <div>
                    <i class="fa-solid fa-trash padd1 b pointer textdanger" data-type='removeButton' data-code='${obj}' title='Quitar item'></i>
                </div>
                <div>
                    ${obj} 
                </div>
            </div> 
            <div class='gridtable__item--structured grid-fill4'>${dataItem.ItemName}</div>
            <div class='gridtable__item--structured b'>$ ${moneyFormat(unitPrice)}</div>
            <div class='gridtable__item centered'>                
                <input type='number' value='${dataItem.itemCount}' min='1' class='large b' data-type='countInput' data-code='${obj}'>                
            </div>
            <div class='gridtable__item--structured b'>$ ${moneyFormat(finalPrice)} ${currency}</div>
            `

            fragment.appendChild(item)
        }


        // Create de final row with final value of bill
        let finalItem = document.createElement('div')
        finalItem.setAttribute('class', 'gridtable__classic')

        finalItem.innerHTML = `
        <div class='gridtable__item grid-fill5'></div>
        <div class='gridtable__item grid-fill3'><div class='b fs1-5 centered textfine padd'>Total $ ${moneyFormat(total)}</div></div>`

        fragment.appendChild(finalItem)





        // load fragment to container
        boardContentContainer.appendChild(fragment)

    }
}