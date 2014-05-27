<div class="esq" id="logo">
    <img src="img/logo.png" alt="logo" />
</div>

<div id="menu" class="dir">
    <ul>
        <?php if (isset($_SESSION['nome'])) { ?>

            <?php if ($_SESSION['tipo_utilizador'] == "admin") { ?>
                <li style="color: yellow;">Olá administrador <?php echo $_SESSION['nome']; ?></li>
                <li><a href="adminPanel/">Zona Admin</a></li>
            <?php } else { ?>
                <li style="color: yellow;">Olá <?php echo $_SESSION['nome']; ?></li>
                <li><a href="index.php?area=inserir_roteiro">Inserir Roteiro</a></li>
            <?php } ?>

            <li><a href="logout.php">Logout</a></li>

        <?php } else { ?>
            <li><a id="login" href="<?php echo devolveUrlActual() . '&log=login'; ?>">Login</a></li>
            <li><a id="registo" href="<?php echo devolveUrlActual() . '&log=registo'; ?>">Registo</a></li>
        <?php } ?>
    </ul>
</div>

<div id="nav" class="dir">
    <ul>
        <li><a href="index.php">Início</a></li>
        <li><a href="index.php?area=destinos">Destinos</a></li>
        <li><a href="index.php?area=o_que_procura">O que procura?</a></li>
        <li><a href="index.php?area=galeria">Galeria</a></li>
    </ul>
</div>

<hr />