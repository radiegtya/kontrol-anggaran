<script type="text/javascript">
    $(document).ready(function(){
        var rating = $('<?php echo $selector; ?>');        
        
        //Turn all the select boxes into rating controls
        $(rating).rating();
		
        //Show that we can bind on the select box
        $(rating).bind("change", function(){
            if(confirm("Are you sure want to rate?")){
                $.ajax({
                    type:'get',
                    url: '<?php echo $url; ?>',
                    dataType: 'json',
                    data:'rating='+rating.val(),
                    success:function(data){
                        $('#rating option[value="' + data.ratingAverage + '"]').attr("selected", true);                        
                        alert(data.message)
                    }
                })
            }     
        });			        			
    });		
	
</script>
