 
 	<?php if($error_msg) {  ?>
		<div class='error'>
			 <div class='error_msg' id="error_message">
				<?php
					foreach ($error_msg as $error) {
						echo $error . NEWLINE;
					 }
				?>
			</div>

		</div>
	<?php  } ?>
	
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