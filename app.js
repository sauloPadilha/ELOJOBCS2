const hamburger = document.querySelector('.header .nav-bar .nav-list .hamburger');
const mobile_menu = document.querySelector('.header .nav-bar .nav-list ul');
const menu_item = document.querySelectorAll('.header .nav-bar .nav-list ul li a');
const header = document.querySelector('.header.container');

// Toggle para abrir/fechar o menu mobile
hamburger.addEventListener('click', () => {
	hamburger.classList.toggle('active');
	mobile_menu.classList.toggle('active');
});

// Muda a cor do header ao fazer scroll
document.addEventListener('scroll', () => {
	const scroll_position = window.scrollY;
	if (scroll_position > 250) {
		header.style.backgroundColor = '#29323c';
	} else {
		header.style.backgroundColor = 'transparent';
	}
});

// Adiciona funcionalidade para o menu mobile e apelidos na URL
menu_item.forEach((item) => {
	item.addEventListener('click', (e) => {
		e.preventDefault(); // Previne o comportamento padrão do link

		// Fecha o menu mobile
		hamburger.classList.toggle('active');
		mobile_menu.classList.toggle('active');

		// Apelidos para o navegador
		const targetId = item.getAttribute('href').substring(1); // ID do destino
		const alias = item.getAttribute('data-alias'); // Apelido

		// Atualiza a URL na barra do navegador
		history.pushState(null, null, `/${alias}`);

		// Faz a rolagem suave para o elemento correspondente
		document.getElementById(targetId).scrollIntoView({
			behavior: 'smooth',
		});
	});
});

// Monitora mudanças no histórico para rolar para a seção correta ao usar Voltar/Avançar
window.addEventListener('popstate', () => {
	const alias = window.location.pathname.substring(1); // Obtém o apelido da URL
	const targetSection = [...menu_item].find(
		(link) => link.getAttribute('data-alias') === alias
	);

	if (targetSection) {
		const targetId = targetSection.getAttribute('href').substring(1);
		document.getElementById(targetId).scrollIntoView({ behavior: 'smooth' });
	}
});
