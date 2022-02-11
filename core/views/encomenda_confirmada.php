<div class="container">
    <div class="row my-5">
        <div class="col text-center">
            <h3>Encomenda confirmada</h3>
            <p>Muito obrigado por comprar conosco!</p>
            <div class="my-5">
                <h4>Dados para pagamento</h4>
                <p>Conta bancária: 12345567</p>
                <p><strong>Código da encomenda: </strong><?= $codigo_encomenda ?></p>
                <p><strong>Valor total da encomenda: </strong><?= "R$ ".number_format($total_encomenda,2,',','.') ?></p>
            </div>
            <p> Você receberá um e-mail com a confirmação da encomenda e os dados para pagamento
                <br>
                A sua encomenda será enviada após a confirmação do pagamento.   
            </p>
            <p><small>Por favor verifique se o e-amil aparece na sua caixa de entrada ou se foi para a área de SPAM</small></p>
            <div class="my-5">
                <a href="?a=inicio" class="btn btn-primary">Voltar</a>
            </div>
        </div>
    </div>
</div>