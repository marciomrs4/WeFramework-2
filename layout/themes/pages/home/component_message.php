<div class="jumbotron">
    <?php
    if(isset($component_message))
        echo '<h2>' . $component_message . '</h2>';
    ?>
    <p class="lead">Status do componente: <?php echo (isset($component_message) ? 'Carregado' : 'Componente não carregado') ?></p>
</div>

<div class="row marketing">
    <div class="col-lg-6">
        <h4>Scalability</h4>
        <p>Construa aplicações pequenas, médias e porque não grande de porte?!</p>

        <h4>Modular</h4>
        <p>O We Framework é modular e conseguimos facilmente criar pacotes de módulos e distribuir pelas aplicações.</p>

    </div>

    <div class="col-lg-6">
        <h4>Multipurpose</h4>
        <p>Construa websites para qualquer tipo de seguimento de maneira fácil e rápida.</p>

        <h4>Easy Easy</h4>
        <p>Uma ferramenta muito fácil de usar, defina como você quer que o We Framework funcione para se adequar as suas
            necessidades atrés de arquivos de configurações.</p>
    </div>
</div>