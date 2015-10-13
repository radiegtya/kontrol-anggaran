<!-- FLASH MESSAGE -->

<?php foreach (Yii::app()->user->getFlashes() as $key => $message): ?>
    <script>                       
        $(function(){
            $.ambiance({
                message: "<?php echo $message; ?>  ", 
                title: "",
                type: "<?php echo $key; ?>  ",
                timeout: 5
            });
        })
    </script>
<?php endforeach; ?>