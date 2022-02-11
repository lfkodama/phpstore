<div class="container">
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            <h3 class="text-center">Registro de Novo Cliente</h3>

            <form action="?a=criar_cliente" method="post">
                <!-- E-mail -->
                <div class="my-3">
                    <label>E-mail</label>
                    <input type="email" name="text_email" required placeholder="E-mail" class="form-control">
                </div>

                <!-- Senha_1 -->
                <div class="my-3">
                    <label>Senha</label>
                    <input type="password" name="text_senha_1" required placeholder="Senha" class="form-control">
                </div>

                <!-- Senha_2 -->
                <div class="my-3">
                    <label>Repetir a senha</label>
                    <input type="password" name="text_senha_2" required placeholder="Repetir a Senha" class="form-control">
                </div>

                <!-- Nome Completo -->
                <div class="my-3">
                    <label>Nome Completo</label>
                    <input type="text" name="text_nome_completo" required placeholder="Nome Completo" class="form-control">
                </div>

                <!-- Endereço -->
                <div class="my-3">
                    <label>Endereço</label>
                    <input type="text" name="text_endereco" required placeholder="Endereço" class="form-control">
                </div>

                <!-- Cidade -->
                <div class="my-3">
                    <label>Cidade</label>
                    <input type="text" name="text_cidade" required placeholder="Cidade" class="form-control">
                </div>

                <!-- Estado -->
                <div class="my-3">
                    <label>Estado</label>
                    <input type="text" name="text_estado" required placeholder="Estado" class="form-control">
                </div>

                <!-- Telefone -->
                <div class="my-3">
                    <label>Telefone</label>
                    <input type="text" name="text_telefone" placeholder="Telefone" class="form-control">
                </div>

                <!-- Submit do Form -->
                <div class="my-4">
                    <input type="submit" value="Criar Conta" class="btn btn-primary">
                </div>

                <!-- Mensagem de erro da validação da senha -->
                <?php if(isset($_SESSION['erro'])): ?>
                    <div class="alert alert-danger text-center p-2">
                        <?= $_SESSION['erro'] ?>
                        <?php unset($_SESSION['erro']); ?>
                    </div>    
                <?php endif; ?>

            </form>


        </div>
    </div>
</div>