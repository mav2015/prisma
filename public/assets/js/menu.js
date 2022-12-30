const hamburger = document.getElementById('main__menu--hamburger');
const main__menu = document.getElementById('main__menu');
const main__ul = document.getElementById('main__ul');


hamburger.addEventListener('click', ()=>{
	hamburger.classList.toggle('main__menu--hamburger-active');
	main__menu.classList.toggle('main__menu--active');
});




// show menu
function showMenu(menuItems){

	main__ul.innerHTML=`<li class='menu-pad'><a href='${URL}' class='main__menu--btn'>Principal|</a></li>`

	//menuItems['signedIn'] && (main__ul.innerHTML+=`<li class='menu-pad'><a href='${URL}/dashboard/' class='main__menu--btn'>Venta</a></li>`)
	
	if((menuItems['signedIn'] && menuItems['referrer'] == true) || menuItems['Superuser'] == 'tYES'){
		main__ul.innerHTML+=`<li class='menu-pad'><a href='${URL}/payments/' class='main__menu--btn'>Métodos de Pago|</a></li>`
	}

	main__ul.innerHTML+=`<li class='menu-pad'><a href='${URL}/prisma/' class='main__menu--btn'>Promesas de Pago|</a></li>`

	// My account
	menuItems['signedIn'] && (main__ul.innerHTML+=`<li class='main__menu--sup'><span class='main__menu--btn'>Mi cuenta|<span class='main__menu--arrow'>^</span></span>
		<ul class='main__menu--sub'>
			<div class='main__menu--userName'>	
				<i class='fa-solid fa-user'></i> ${menuItems['shortname']}
			</div>
			
			<li><a href="${URL}/acm/logout" class='main__menu--btn'>Salir</a></li>
		</ul></li>`)


		
	// SignIn
	menuItems['signIn'] && (main__ul.innerHTML+=`<li class='menu-pad'><a href='${URL}/acm/login' class='main__menu--btn'>Ingresar</a></li>`)
}



// Checking session status and menu items
menuStored = sStorage('USER')

if(menuStored){
	
	showMenu({
		"signedIn":true,
		...menuStored
	})

}else{

	getRequest(`/menu`)
	.then(r=>{

		if(r.status !== 200 || r.content === false){
			showMenu({"signIn":true})
		}else{

			sStorage('USER',r.content)

			showMenu({
				"signedIn": true,
				...sStorage('USER')
			})

		}

	})
}