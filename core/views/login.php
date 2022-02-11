<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4 offset-sm-4">
            <div>
                <h3  class="text-center">LOGIN</h3>
                <form action="?a=login_submit" method="post">
                    <div class="my3">
                        <label>Usuário:</label>
                        <input type="email" name="text_usuario" placeholder="Usuário" required class="form-control">
                    </div>

                    <div class="my3">
                        <label>Senha:</label>
                        <input type="password" name="text_password" placeholder="Senha" required class="form-control">
                    </div>

                    <div class="my-3">
                        <input type="submit" value="Entrar" class="btn btn-primary">
                    </div>
                </form>
                <!-- Mensagem de erro da validação do login -->
                <?php if(isset($_SESSION['erro'])): ?>
                    <div class="alert alert-danger text-center p-2">
                        <?= $_SESSION['erro'] ?>
                        <?php unset($_SESSION['erro']); ?>
                    </div>    
                <?php endif; ?>  
            </div>
        </div>
    </div>
</div>