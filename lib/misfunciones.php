<?php
function miretorno($post){
    
    foreach ($post as $boton){
        if($boton != ""){
            return "se ha pulsado $boton";
        }
        
    }
}

?>
