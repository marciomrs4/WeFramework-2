<body>
    <div class="container">
        <div class="header">
            <ul class="nav nav-pills pull-right">
                <li <?= (RequirePage('home') || RequirePage(''))?'class="active"':'' ?> ><a href="<?=BaseUrl()?>">Home</a></li>
                <li <?= (RequirePage('test'))?'class="active"':'' ?> ><a href="<?=BaseUrl()?>test">Página de Teste</a></li>
            </ul>
            <h3 class="text-muted"><b>We Framework</b> | App and Front</h3>
        </div>