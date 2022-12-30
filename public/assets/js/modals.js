var modal = (status = true) => {

	const modalContainer = document.getElementById('modalcontainer');
	
	// Reset modal content and style
	modalContainer.children.modal.innerHTML = ''
	modalContainer.children.modalclose.classList.remove('undisplay')
	modalContainer.classList.remove('transparent')

	
	if(status == false){
		modalContainer.classList.add('modal__hide')
		return false;
	}

	if(status == 'transparent'){
		modalContainer.classList.add('transparent')
	}else if(status == 'loading'){
		modalContainer.children.modal.innerHTML="<div class='centered'><div class='padd2 fs2 st-classic'>Cargando <i class='fa-solid fa-spinner fa-spin'></i></div></div>"
		modalContainer.children.modalclose.classList.add('undisplay')
	}else if(status == 'transparentLoading'){
		modalContainer.classList.add('transparent')
		modalContainer.children.modalclose.classList.add('undisplay')

		modalContainer.children.modal.innerHTML="<div class='centered'><div class='padd2 fs2 st-classic'>Cargando <i class='fa-solid fa-spinner fa-spin'></i></div></div>"
	}


	modalContainer.classList.remove('modal__hide')
	
	return modalContainer.children.modal
}

document.getElementById('modalclose').addEventListener('click', (e)=>{
	e.target.parentNode.classList.add('modal__hide')
})






function confirmation(message, fn) {
	const confirmationBox = document.createElement("div");
	confirmationBox.innerHTML = `<div class='confirmation-modal'>
			<div class='confirmation_container'>
				<span class='confirmation_txt'>${message}</span>
				<button id='confirmationCancel' class='btn st-natural'>Cancelar</button>
				<button id='confirmationOk' class='btn st-warning'>Ok</button>
			</div>
		</div>`;
	document.body.appendChild(confirmationBox);

	document.getElementById('confirmationCancel').addEventListener("click", () => { document.body.removeChild(confirmationBox); });
	document.getElementById('confirmationOk').addEventListener("click", () => { fn(); document.body.removeChild(confirmationBox); });
}
