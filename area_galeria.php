<?php
$sql = "SELECT titulo, imagem FROM roteiro WHERE ativo=1";
$result = mysql_query($sql);
?>
<div id="galeria">
    <?php
    if (@mysql_num_rows($result)) {
        ?>
        <ul id="miniFotos" class="clearfix">
            <?php
            while ($row = mysql_fetch_assoc($result)) {
                ?>
                <li><img src="<?php echo 'img/mini_' . $row['imagem']; ?>" alt="<?php echo utf8_encode($row['titulo']); ?>"/></li>
                <?php
            }
            ?>
        </ul>
        <?php
    }
    ?>
</div>