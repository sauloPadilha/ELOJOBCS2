const hamburger = document.querySelector('.header .nav-bar .nav-list .hamburger');
const mobile_menu = document.querySelector('.header .nav-bar .nav-list ul');
const menu_item = document.querySelectorAll('.header .nav-bar .nav-list ul li a');
const header = document.querySelector('.header.container');

hamburger.addEventListener('click', () => {
	hamburger.classList.toggle('active');
	mobile_menu.classList.toggle('active');
});

document.addEventListener('scroll', () => {
	var scroll_position = window.scrollY;
	if (scroll_position > 250) {
		header.style.backgroundColor = '#29323c';
	} else {
		header.style.backgroundColor = 'transparent';
	}
});

menu_item.forEach((item) => {
	item.addEventListener('click', () => {
		hamburger.classList.toggle('active');
		mobile_menu.classList.toggle('active');
	});
});

// Exibe o pop-up ao carregar o site
window.onload = function () {
    const popup = document.getElementById("popup");
    const acceptCookies = document.getElementById("accept-cookies");
    const declineCookies = document.getElementById("decline-cookies");
    const enableNotifications = document.getElementById("enable-notifications");

    // Mostra o popup
    popup.classList.add("active");

    // Ações para aceitar cookies
    acceptCookies.addEventListener("click", function () {
        localStorage.setItem("cookiesAccepted", "true");
        if (enableNotifications.checked) {
            console.log("Notificações ativadas.");
            // Ative notificações via Push API ou outro método aqui.
        }
        popup.classList.remove("active");
    });

    // Ações para recusar cookies
    declineCookies.addEventListener("click", function () {
        console.log("Cookies recusados.");
        popup.classList.remove("active");
    });

    // Verifica se os cookies já foram aceitos
    if (localStorage.getItem("cookiesAccepted") === "true") {
        popup.classList.remove("active");
    }
};

