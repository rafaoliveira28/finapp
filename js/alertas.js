function resultadoCadastro(mensagem) {
    Swal.fire({
        text: mensagem,
    })
}

function alertaSucesso(mensagem) {
    Swal.fire({
        position: "center",
        icon: "success",
        title: mensagem,
        showConfirmButton: false,
        timer: 1500
    });
}

function alertaErro(mensagem) {
    Swal.fire({
        position: "center",
        icon: "error",
        title: mensagem,
        showConfirmButton: true,
    });
}

function alertaDesconhecido(mensagem) {
    Swal.fire({
        position: "center",
        icon: "question",
        title: mensagem,
        showConfirmButton: true,
    });
}

function confirmaDeletaPedido(idpedido, pagina) {
    Swal.fire({
        title: "Tem certeza?",
        text: "A exclusão de pedidos é irreversível e não retorna a quantidade dos produtos para o estoque!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "green",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, deletar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href='deletepedido.php?idpedido=' + idpedido + '&pagina=' + pagina;
        }
    });
}