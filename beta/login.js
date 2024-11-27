// Alternar entre as telas de login, cadastro e recuperação
document.getElementById('go-to-register').addEventListener('click', () => toggleForm('register'));
document.getElementById('go-to-login').addEventListener('click', () => toggleForm('login'));
document.getElementById('go-to-forgot').addEventListener('click', () => toggleForm('forgot'));
document.getElementById('go-back-login').addEventListener('click', () => toggleForm('login'));

function toggleForm(form) {
    document.getElementById('login-form').classList.add('hidden');
    document.getElementById('register-form').classList.add('hidden');
    document.getElementById('forgot-form').classList.add('hidden');
    document.getElementById(`${form}-form`).classList.remove('hidden');
}

// Lógica de envio (simples para fins de demonstração)
document.getElementById('login-button').addEventListener('click', (e) => {
    e.preventDefault();
    alert('Logado com sucesso!');
});

document.getElementById('register-button').addEventListener('click', (e) => {
    e.preventDefault();
    alert('Cadastro realizado!');
});

document.getElementById('forgot-button').addEventListener('click', (e) => {
    e.preventDefault();
    alert('E-mail para recuperação enviado!');
});
