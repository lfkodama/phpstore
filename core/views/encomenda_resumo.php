<div class="container">
    <div class="row">
        <div class="col">
            <h3 class="my-3">Seu pedido - RESUMO</h3>
        </div>
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col">


                <div style="margin-bottom: 80px;">
                    <table class="table">
                        <thead>
                            <tr>
                            
                                <th>Produto</th>
                                <th class="text-center">Quantidade</th>
                                <th class="text-end">Valor Total</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $index = 0;
                            $total_rows = count($carrinho);
                            ?>
                            <?php foreach($carrinho as $produto): ?>
                                <?php if($index < $total_rows -1) : ?>
                                    <!-- Lista os produtos -->
                                    <tr>
                                        <td class="align-middle"><?= $produto['titulo']?></td>
                                        <td class="text-center align-middle"><?= $produto['quantidade']?></td>
                                        <td class="text-end align-middle"><?= 'R$ ' . str_replace('.',',', number_format($produto['preco'], 2))?></td>
                                        
                                    </tr>
                                <?php else : ?>
                                    <!-- Total -->
                                    <tr>
                                        
                                        <td></td>
                                        <td class="text-end"><h4>Total:</h4></td>
                                        <td class="text-end"><h4><?= 'R$ ' . str_replace('.',',', number_format($produto, 2)) ?></h4></td>
                                    </tr>      
                                <?php endif; ?>
                                <?php $index++ ?>      
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    
                    <h4 class="bg-dark text-white p-2">Dados do Cliente</h4>
                    <div class="row mt-4">
                        <div class="col">
                            <p>Nome: <strong><?= $cliente->full_name ?></strong></p>
                            <p>ENdereço: <strong><?= $cliente->address ?></strong></p>
                            <p>Cidade: <strong><?= $cliente->city ?></strong></p>
                        </div>
                        <div class="col">
                            <p>E-mail: <strong><?= $cliente->email ?></strong></p>
                            <p>Telefone: <strong><?= $cliente->phone ?></strong></p>        
                        </div>
                        
                        
                    </div>


                    <!-- DADOS DE PAGAMENTO -->
                    <h3 class="bg-dark text-white p-2">Dados do Pagamento</h3>
                    <div class="row">
                        <div class="col">
                            <p>Conta bancária: 123456789</p>
                            <p>Código da encomenda: <strong><?= $_SESSION['codigo_encomenda'] ?></strong></p>
                            <p>Total: <strong><?= 'R$ ' . str_replace('.',',', number_format($produto, 2)) ?></strong></p>
                        </div>
                    </div>

                    <!-- Endereço alternativo de entrega -->                
                    <h5 class="bg-dark text-white p-2">Endereço alternativo para entrega</h5>
                    <div class="form-check mb-3">
                        <input class="form-check-input" onchange="usar_endereco_alternativo()" type="checkbox" name="check_endereco_alternativo" id="check_endereco_alternativo">
                        <label class="form-check-label" for="check_endereco_alternativo">Desejo informar um endereço de entrega diferente</label>
                    </div>

                    <div id="endereco_alternativo" style="display: none">
                        <div class="mb-3">
                            <label class="form-label">Nome Completo:</label>
                            <input type="text" class="form-control" id="text_nome_alternativo">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Endereço:</label>
                            <input type="text" class="form-control" id="text_endereco_alternativo">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cidade:</label>
                            <input type="text" class="form-control" id="text_cidade_alternativo">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Telefone:</label>
                            <input type="text" class="form-control" id="text_telefone_alternativo">
                        </div>
                    </div>


                    

                    <div class="row mt-4">
                        <div class="col">
                            <a href="?a=carrinho" class="btn btn-primary">Cancelar</a>
                        </div>

                        <div class="col text-end">
                            <a href="?a=confirmar_pedido" onclick="definir_endereco_alternativo()" class="btn btn-primary">Confirmar Pedido</a>       
                        </div>
                    </div>

                </div>            

            
        </div>
    </div>
</div>