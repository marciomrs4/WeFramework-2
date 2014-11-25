<div class="jumbotron">
    <p class="lead">Olá, essa é a página de teste.</p>
</div>
<?php
    if(isset($message))
    {
        if($status == true)
        {
            ?>
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Sucesso!</strong> <?=$message?>
            </div>
            <?php
        }
        else
        {
            ?>
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Error!</strong> <?=$message?>
            </div>
            <?php
        }
    }
?>
<div class="col-md-12">
    <form role="form" method="post">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" name="email">
      </div>
      <div class="form-group">
        <label for="pwd">Senha:</label>
        <input type="password" class="form-control" name="passwd">
      </div>
      <button type="submit" class="btn btn-default">Testar</button>
    </form>
</div>