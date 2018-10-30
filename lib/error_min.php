 
	
    <?php if($query_msg) {  ?>
    <div class='query'>
         <div class='query_msg' id="query_message">
            <?php
                foreach ($query_msg as $query) {
                    echo $query . NEWLINE;
                 }

            ?>
        </div>

    </div>
	<?php } ?>