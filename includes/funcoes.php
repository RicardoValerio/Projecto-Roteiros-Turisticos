<?php
function getHash($prefix, $id) {
    return hash('sha512', $prefix.$id);
}
?>
