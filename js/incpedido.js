//Busca os produtos do cliente no banco, para inclusão de pedido.
$(document).ready(function() {
    $('#search').on('input', function() {
        var searchText = $(this).val();
        if (searchText.length >= 2) {
            $.ajax({
                url: 'search.php',
                method: 'POST',
                data: { search: searchText },
                dataType: 'json',
                success: function(response) {
                    $('#results').empty();
                    response.forEach(function(item) {
                        var listItem = $('<button type="button" class="search-item list-group-item list-group-item-action">' + item.idprodserv + ' - '+ item.ca_nome + '</button>');
                        listItem.data('itemData', item);
                        $('#results').append(listItem);
                    });
                    $('#results').show();
                }
            });
        } else {
            $('#results').empty();
            $('#results').hide();
        }
    });

// Adiciona um evento de clique aos itens da busca

$('#results').on('click', '.search-item', function() {
    var itemData = $(this).data('itemData');
    var idprodserv = itemData.idprodserv;

    var existingInput = $('#idprodserv input[value="' + idprodserv + '"]');
    if (existingInput.length > 0) {
        alert('Produto já incluso na lista! Altere a quantidade do produto já existente.');
    } else {
        $('#search').val('');
        $('#results').empty();
        $('#results').hide();
        $("<input readonly class='form-control' aria-describedby='basic-addon1' style='font-size: 11px; margin-bottom: 10px;' type='text'>").attr({
            type: 'text',
            name: 'idprodserv[]',
            value: itemData.idprodserv
        }).appendTo('#idprodserv');
        $("<input readonly class='form-control' aria-describedby='basic-addon1' style='font-size: 11px; margin-bottom: 10px;' type='text'>").attr({
            type: 'text',
            name: 'ca_nome[]',
            value: itemData.ca_nome
        }).appendTo('#ca_nome');
        $("<input readonly class='form-control' aria-describedby='basic-addon1' style='font-size: 11px; margin-bottom: 10px;' type='text'>").attr({
            type: 'text',
            name: 'ca_valor[]',
            value: itemData.ca_valor
        }).appendTo('#ca_valor');
        $("<input class='form-control quantidade-input' aria-describedby='basic-addon1' style='font-size: 11px; margin-bottom: 10px;' type='text' name='ca_quantidade[]' value='1'>").attr({
            type: 'text',
            'data-max-quantity': itemData.ca_quantidade
        }).appendTo('#ca_quantidade');   
        atualizaTotal();
    }
    
    $(document).on('focus change', 'input[name="ca_quantidade[]"]', function() {
        var index = $('input[name="ca_quantidade[]"]').index(this);
        var idProduto = $('input[name="idprodserv[]"]').eq(index).val();
    
        $.ajax({
            url: 'search.php',
            method: 'POST',
            data: { idprodserv: idProduto },
            dataType: 'json',
            success: function(response) {
                $('#results').empty();
                response.forEach(function(item) {
                    var valor = item.ca_valor;
                    var quantidade = parseFloat($('input[name="ca_quantidade[]"]').eq(index).val().replace(',', '.'));
                    var novoValor = (valor * quantidade).toFixed(2);
                    $('input[name="ca_valor[]"]').eq(index).val(novoValor);
                    atualizaTotal();
                });
                $('#results').show();
            }
        });
    });
    
});

function atualizaTotal() {
    var valores = $('input[name="ca_valor[]"]');
    var total = 0;
    
    valores.each (function() {
        itemValor = parseFloat($(this).val().replace(',', '.')) || 0;
        total += itemValor;
    });

    total = "Total: " + total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

    if ($('#valor_total b').length) {
        $('#valor_total b').text(total);
    } else {
        $("<b></b>").text(total).appendTo('#valor_total');
    };    
};


//Confirma se o produto adicionado tem estoque disponível
    $('#submitBtn').on('click', function() {
        var quantidades = $('input[name="ca_quantidade[]"]');
        var valid = true;

        quantidades.each(function() {
            var quantidadeInput = $(this);
            var quantidade = parseInt(quantidadeInput.val());
            var quantidadeEstoque = parseInt(quantidadeInput.data('max-quantity'));

            if (quantidade > quantidadeEstoque) {
                valid = false;
                quantidadeInput.addClass('text-danger font-weight-bold');
            } else {
                quantidadeInput.removeClass('text-danger font-weight-bold');
            }
        });

        if (!valid) {
            alert('Quantidade solicitada de algum produto excede a quantidade em estoque.');
            return false;
        }
    });
});
