const productViewerSearchBarContainer = document.getElementById('productViewerSearchBarContainer')
const productviewerSelectContainer = document.getElementById('productviewerSelectContainer')
const productBusinessUnitSelect = document.getElementById('productBusinessUnitSelect')


const [pV_searchForm, pV_searchInput] = navSearch(productViewerSearchBarContainer, null, false);

const searchProducts = () => {
    modal('transparentLoading')

    getRequest(`/products/getall/?search=${pV_searchInput.value}&division=${productBusinessUnitSelect.value}`)
        .then(r => {

            modal(false)

            let fragment = document.createDocumentFragment()


            if (r.content === false) return mssg('Producto no encontrado','e')
            if (r.status !== 200 && r.message !== null)return mssg(r.message, 'e')

            r.content.map(response => {

                let item = document.createElement('option')
                item.setAttribute('data-data',JSON.stringify(response))
                item.setAttribute('data-type','select')
                item.innerHTML = `<div class='flexcontainer gap'>
                    <div class=''>${response.ItemCode}</div>
                    <div class='wrap'>${response.ItemName} </div>
                </div>`

                fragment.appendChild(item)
            })


            productviewerSelectContainer.innerHTML = '<option class="centered fs" disabled>Doble click para agregar al carrito</option>'
            productviewerSelectContainer.appendChild(fragment)

        })
}

