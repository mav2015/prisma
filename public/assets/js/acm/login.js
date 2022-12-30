const formLogin = document.getElementById('formLogin');

//clean menu
main__ul.innerHTML=''
sStorage('USER','')


// checking login
formLogin.addEventListener('submit',(e)=>{
	e.preventDefault();

	let user = e.target.user.value.trim()
	let password = e.target.password.value.trim()


	if(user.length < 4 || password.length < 4) return mssg('Los campos deben contener al menos 4 dígitos. No uses espacios en blanco.', 'e')
	

	modal('transparentLoading');

	postRequest('/acm/checklogin/', `user=${user}&password=${password}`)
	.then(r=>{

		modal(false);

		if(!r.content) return mssg(r.message,'e')

		mssg(`Bienvenido/a ${r.content}`)
		
		setTimeout(()=>{document.location.href=`${URL}/principal`;} , 100);		

	});

});