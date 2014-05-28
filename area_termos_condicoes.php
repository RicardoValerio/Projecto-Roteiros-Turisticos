<img src="img/bannerTermCond.jpg" alt=""/>

<div id="termosCondicoes">
    <div class="separador">
        <hr />
        <img src="img/separador_local.jpg" alt="" />
    </div>
    <h1><span id="normal">Termos </span><span id="semiBold">& </span>Condições</h1>

    <?php
    $local = "termos_condicoes";

    $sql_verificaExiste = "SELECT * FROM texto WHERE local = '$local'";
    $result_verificaExiste = mysql_query($sql_verificaExiste);
    if (@mysql_num_rows($result_verificaExiste)) {
        $row = mysql_fetch_assoc($result_verificaExiste);
        echo $row['texto'];
    }
    ?>
</div>