document.getElementById('cpf').addEventListener('input', function (event) {
    var cpf = event.target.value.replace(/\D/g, '');
    if (cpf.length > 11) {
        cpf = cpf.substring(0, 11);
    }
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    event.target.value = cpf;
});

document.getElementById('cnpj').addEventListener('input', function (event) {
    var cnpj = event.target.value.replace(/\D/g, '');
    if (cnpj.length > 14) {
        cnpj = cnpj.substring(0, 14);
    }
    cnpj = cnpj.replace(/^(\d{2})(\d)/, '$1.$2');
    cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
    cnpj = cnpj.replace(/\.(\d{3})(\d)/, '.$1/$2');
    cnpj = cnpj.replace(/(\d{4})(\d)/, '$1-$2');
    event.target.value = cnpj;
});

document.getElementById('telefone').addEventListener('input', function (event) {
    var telefone = event.target.value.replace(/\D/g, '');
    if (telefone.length > 11) {
        telefone = telefone.substring(0, 11);
    }
    if (telefone.length > 10) {
        telefone = telefone.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    } else {
        telefone = telefone.replace(/^(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
    }
    event.target.value = telefone;
});

document.getElementById('cep').addEventListener('input', function (event) {
    var cep = event.target.value.replace(/\D/g, '');
    if (cep.length > 8) {
        cep = cep.substring(0, 8);
    }
    cep = cep.replace(/^(\d{5})(\d)/, '$1-$2');
    event.target.value = cep;
});

document.getElementById('email').addEventListener('blur', function (event) {
    var email = event.target.value;
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var errorMessageElement = document.getElementById('mensagemErroemail');
    
    if (!emailPattern.test(email)) {
        event.target.style.color = 'red';
        event.target.setCustomValidity('Por favor, insira um email válido.');
        errorMessageElement.textContent = 'Por favor, insira um email válido.';
    } else {
        event.target.style.color = 'black';
        event.target.setCustomValidity('');
        errorMessageElement.textContent = '';
    }
});
