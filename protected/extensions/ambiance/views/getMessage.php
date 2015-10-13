<!-- FLASH MESSAGE -->
    <script>                       
        $(function(){
            $.ambiance({
                message: "<?php echo $message; ?>", 
                title: "<?php echo $key; ?>",
                type: "<?php echo $key; ?>",
                timeout: 5
            });
        })
    </script>