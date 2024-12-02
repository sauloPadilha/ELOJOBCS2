const hamburger = document.querySelector('.header .nav-bar .nav-list .hamburger');
const mobile_menu = document.querySelector('.header .nav-bar .nav-list ul');
const menu_item = document.querySelectorAll('.header .nav-bar .nav-list ul li a');
const header = document.querySelector('.header.container');

hamburger.addEventListener('click', () => {
	hamburger.classList.toggle('active');
	mobile_menu.classList.toggle('active');
});

document.addEventListener('scroll', () => {
	const scroll_position = window.scrollY;
	if (scroll_position > 250) {
		header.style.backgroundColor = '#29323c';
	} else {
		header.style.backgroundColor = 'transparent';
	}
});

menu_item.forEach((item) => {
	item.addEventListener('click', (e) => {
		e.preventDefault();

		hamburger.classList.toggle('active');
		mobile_menu.classList.toggle('active');

		const targetId = item.getAttribute('href').substring(1);
		const alias = item.getAttribute('data-alias');

		history.pushState(null, null, `/${alias}`);

		document.getElementById(targetId).scrollIntoView({
			behavior: 'smooth',
		});
	});
});

window.addEventListener('popstate', () => {
	const alias = window.location.pathname.substring(1);
	const targetSection = [...menu_item].find(
		(link) => link.getAttribute('data-alias') === alias
	);

	if (targetSection) {
		const targetId = targetSection.getAttribute('href').substring(1);
		document.getElementById(targetId).scrollIntoView({ behavior: 'smooth' });
	}
});

let currentPoints = null;
let desiredPoints = null;
let currentLevel = null;
let desiredLevel = null;

function showPlaceOrderButton(orderLink, buttonId) {
    const placeOrderButton = document.getElementById(buttonId);
    placeOrderButton.href = orderLink;
    placeOrderButton.style.display = "inline-block";
}

document.querySelectorAll("#currentPoints img").forEach((img) => {
    img.addEventListener("click", () => {
        document.querySelectorAll("#currentPoints img").forEach((img) => img.classList.remove("selected"));
        img.classList.add("selected");
        currentPoints = parseInt(img.dataset.points);
        calculateCE();
    });
});

document.querySelectorAll("#desiredPoints img").forEach((img) => {
    img.addEventListener("click", () => {
        document.querySelectorAll("#desiredPoints img").forEach((img) => img.classList.remove("selected"));
        img.classList.add("selected");
        desiredPoints = parseInt(img.dataset.points);
        calculateCE();
    });
});

document.querySelectorAll("#currentLevels img").forEach((img) => {
    img.addEventListener("click", () => {
        document.querySelectorAll("#currentLevels img").forEach((img) => img.classList.remove("selected"));
        img.classList.add("selected");
        currentLevel = parseInt(img.dataset.level);
        calculateGC();
    });
});

document.querySelectorAll("#desiredLevels img").forEach((img) => {
    img.addEventListener("click", () => {
        document.querySelectorAll("#desiredLevels img").forEach((img) => img.classList.remove("selected"));
        img.classList.add("selected");
        desiredLevel = parseInt(img.dataset.level);
        calculateGC();
    });
});

function calculateCE() {
    if (currentPoints === null || desiredPoints === null) return;
    if (currentPoints >= desiredPoints) {
        document.getElementById("resultCE").textContent = "Os pontos desejados devem ser maiores que os pontos atuais.";
        document.getElementById("placeOrderCE").style.display = "none";
        return;
    }

    const ranges = [
        { max: 4999, price: 35 },
        { max: 9999, price: 40 },
        { max: 14999, price: 50 },
        { max: 19999, price: 65 },
        { max: 24999, price: 90 },
        { max: 25000, price: 120 },
    ];

    let totalPrice = 0;
    for (let i = currentPoints; i < desiredPoints; i += 1000) {
        const range = ranges.find((r) => i <= r.max);
        totalPrice += range ? range.price : 0;
    }

    const formattedPrice = totalPrice.toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    document.getElementById("resultCE").textContent = `Valor total: R$${formattedPrice}`;

	const orderLink = `https://api.whatsapp.com/send?phone=5511960203264&text=Ol%C3%A1,%20estou%20entrando%20em%20contato%20para%20solicitar%20o%20servi%C3%A7o%20de%20BOOST%20na%20minha%20conta.%20Atualmente,%20estou%20com%20${currentPoints}%20pontos%20e%20desejo%20alcan%C3%A7ar%20${desiredPoints}%20pontos.%20O%20valor%20total%20do%20servi%C3%A7o%20%C3%A9%20de%20R$${formattedPrice}.%20Aguardo%20mais%20informa%C3%A7%C3%B5es%20e%20instru%C3%A7%C3%B5es%20para%20prosseguir.%20Obrigado!`;

    showPlaceOrderButton(orderLink, "placeOrderCE");
}

function calculateGC() {
    if (currentLevel === null || desiredLevel === null) return;
    if (currentLevel >= desiredLevel) {
        document.getElementById("resultGC").textContent = "O nível desejado deve ser maior que o nível atual.";
        document.getElementById("placeOrderGC").style.display = "none";
        return;
    }

    let totalPrice = 0;
    for (let i = currentLevel; i < desiredLevel; i++) {
        if (i < 10) totalPrice += 30;
        else if (i < 14) totalPrice += 50;
        else if (i < 17) totalPrice += 60;
        else if (i < 19) totalPrice += 80;
        else totalPrice += 130;
    }

    const formattedPrice = totalPrice.toLocaleString("pt-BR", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    document.getElementById("resultGC").textContent = `Valor total: R$${formattedPrice}`;

	const orderLink = `https://api.whatsapp.com/send?phone=5511960203264&text=Ol%C3%A1,%20estou%20entrando%20em%20contato%20para%20solicitar%20o%20servi%C3%A7o%20de%20BOOST%20para%20minha%20conta.%20Atualmente,%20estou%20no%20Level%20${currentLevel}%20e%20desejo%20alcan%C3%A7ar%20o%20Level%20${desiredLevel}.%20O%20valor%20total%20do%20servi%C3%A7o%20%C3%A9%20de%20R$${formattedPrice}.%20Aguardo%20mais%20informa%C3%A7%C3%B5es%20e%20instru%C3%A7%C3%B5es%20para%20prosseguir.%20Obrigado!`;

    showPlaceOrderButton(orderLink, "placeOrderGC");
}

function resetModal() {
    currentPoints = null;
    desiredPoints = null;
    currentLevel = null;
    desiredLevel = null;

    document.querySelectorAll(".levels img").forEach((img) => img.classList.remove("selected"));

    document.getElementById("resultCE").textContent = "";
    document.getElementById("resultGC").textContent = "";

    document.getElementById("placeOrderCE").style.display = "none";
    document.getElementById("placeOrderGC").style.display = "none";
}

const modal = document.getElementById("calculationModal");
const closeModal = document.querySelector(".close");
const modalSections = {
    competitivo: document.getElementById("competitivo-section"),
    gamersclub: document.getElementById("gamersclub-section"),
};

document.querySelectorAll(".open-modal").forEach((button) => {
    button.addEventListener("click", (e) => {
        const modalType = e.target.dataset.modal;

        Object.values(modalSections).forEach((section) => (section.style.display = "none"));

        modalSections[modalType].style.display = "block";

        modal.style.display = "flex";
    });
});

closeModal.addEventListener("click", () => {
    modal.style.display = "none";
    resetModal();
});

window.addEventListener("click", (e) => {
    if (e.target === modal) {
        modal.style.display = "none";
        resetModal();
    }
});
