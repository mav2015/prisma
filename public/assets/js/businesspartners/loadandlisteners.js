partnerSearchForm.addEventListener('submit', e => {
    e.preventDefault()

    // Check if request is empty
    if (!noEmpty(partnerSearchInput.value)) return mssg('Debes ingresar algún dato para la búsqueda', 'e')

    searchPartner(searchBy.value, partnerSearchInput.value)

})