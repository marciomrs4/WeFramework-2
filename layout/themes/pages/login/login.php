<div class="jumbotron">
    <h1>Olá.</h1>
    <p class="lead">Este é um exemplo de autenticação, forneça qualquer usuário ou senha para cirar um token de acesso.</p>
</div>
<?php
if(isset($message))
{
    echo $message;
}
?>
<div class="col-md-12">
    <form role="form" method="post">
      <div class="form-group">
        <label for="email">Usuário</label>
        <input type="text" class="form-control" name="user">
      </div>
      <div class="form-group">
        <label for="pwd">Senha:</label>
        <input type="password" class="form-control" name="passwd">
      </div>
      <button type="submit" class="btn btn-default">Entrar</button>
    </form>
</div>