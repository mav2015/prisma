/**
 * 
 * @param {HTMLElement} append 
 * @param {string} id 
 * @param {boolean} submitOnClean 
 * @returns {array} [(HTMLElement) form, (HTMLElement) input]
 */
function navSearch(append=null,id=null,submitOnClean=true){

	let searchForm = document.createElement('FORM')
	searchForm.setAttribute('class','nav__search--container nav__search--item')
	if(id != null) searchForm.setAttribute('id', id)

	const input = document.createElement('input')
	input.setAttribute('type', 'text')
	input.setAttribute('class', 'nav__search--textInput')
	input.setAttribute('placeholder', 'Buscar')
	input.setAttribute('autocomplete', 'off')

	const clear = document.createElement('span')
	clear.setAttribute('class', 'nav__search--clearButton nav__search--hidde')
	clear.setAttribute('title', 'Limpiar el buscador')
	clear.textContent = 'x'

	const subtn = document.createElement('input')
	subtn.setAttribute('type','submit')
	subtn.setAttribute('class','nav__search--hidde')


	searchForm.appendChild(input)
	searchForm.appendChild(clear)
	searchForm.appendChild(subtn)

	if(append != null)append.appendChild(searchForm)


	let submited = false;
    let timmer = ()=>{
        submited = false;
        setTimeout(
            ()=>{
			if( input.value.trim() > '' && !submited){
				input.classList.add('nav__serach--inputFilled')
				clear.classList.remove('nav__search--hidde')
				subtn.click()
			}
            
        }
        ,1500)
    }
        
    
    searchForm.addEventListener('keyup', e=>{
        if(e.code != 'Enter' && e.keyCode != 13 && e.key !='Enter') timmer()       
    })


	clear.addEventListener('click',()=>{
		input.value=''
		input.classList.remove('nav__serach--inputFilled')
		clear.classList.add('nav__search--hidde')
		if(submitOnClean) subtn.click()
	})

	searchForm.addEventListener('submit', (e)=>{
		e.preventDefault()
		submited = true

		if( input.value.trim() > ''){
			input.classList.add('nav__serach--inputFilled')
			clear.classList.remove('nav__search--hidde')
		}
	})
	


	return [searchForm,input]
}





const navBetween = (append=null, id='between')=>{

	const nav = document.createElement('form')
	
	nav.setAttribute('id', id)

	const check = i => /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/.test(i.value) ? 'date' : 'text'; 

	nav.innerHTML = `<input type='text' id='${id}_a' name='between_a' placeholder='Desde:' class='nav__among--item' onfocus=\"this.type='date';\" 
					onblur=\"this.type='${ check(this) }'\" 
					onchange=\"this.type='${ check(this) }'\">

					 <input type='text' id='${id}_b' name='between_b' placeholder='Hasta:' class='nav__among--item' onfocus=\"this.type='date';\" 
					 onblur=\"this.type='${ check(this) }'\" 
					 onchange=\"this.type='${ check(this) }'\">

					 <input type='submit' value='&#128269;'>
					`;

	if(append != null)append.appendChild(nav)


return [nav[0],nav[1],nav];
}







function paginator (currentPage,allPages,selectContainer){

    let fragment = document.createDocumentFragment()

	allPages = allPages < 1 ? 1 : allPages;

    for (var i = 1; i < (allPages + 1); i++) {
        let option = document.createElement('option')
        option.setAttribute('value', i)

        if (currentPage == i) { option.setAttribute('selected', true) }

        option.innerText = `Página ${i}`
        fragment.appendChild(option)
    }

	selectContainer.innerHTML=''
	selectContainer.appendChild(fragment)

    return selectContainer
}





function listItem(find, container){

	const searchInput = navSearch()


	let navBar = document.createElement('nav')
	navBar.setAttribute('class','flexcontainer flex-wrap')

	let navPaginator = document.createElement('select')
	navPaginator.setAttribute('class','nav__search--item')

	let itemsContainer = document.createElement('div')
	itemsContainer.setAttribute('class','flexcontainer padd1 flex-wrap')

	navBar.appendChild(searchInput)
	container.appendChild(navBar)
	container.appendChild(itemsContainer)

	const search = ()=>{
		getRequest(`${find}/?search=${searchInput.children[0].value}&page=${navPaginator.value}`)
		.then(r => {
						
			navBar.appendChild(navPaginator)
			navPaginator.innerHTML=''
			navPaginator.appendChild(paginator(r.content.current,r.content.pages))

			itemsContainer.innerHTML=''

  			let fragment = document.createDocumentFragment()

			r.content.list.map(response=>{

				let item = document.createElement('div')
				item.setAttribute('class','card')
				item.innerHTML=`<div class='card__item'>${response.username}</div>`

				fragment.appendChild(item)
			})

	

			itemsContainer.appendChild(fragment)
			
		})
	
	}


	searchInput.addEventListener('submit',(e)=>{
		e.preventDefault()	
		search()
	})

	navPaginator.addEventListener('change',(e)=>{
		search()
	})

	search()


	return [navBar,itemsContainer]

}
