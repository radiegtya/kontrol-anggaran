<?php
$this->widget('ext.jqrelcopy.JQRelcopy', array(
//the id of the 'Copy' link in the view, see below.
    'id' => 'copylink',
    //add a icon image tag instead of the text
//leave empty to disable removing
    'removeText' => '<i></i>',
    //htmlOptions of the remove link
    'removeHtmlOptions' => array('class' => 'fa fa-fw fa-trash'),
    //options of the plugin, see http://www.andresvidal.com/labs/relcopy.html
    'options' => array(
//A class to attach to each copy
        'copyClass' => 'newcopy',
        // The number of allowed copies. Default: 0 is unlimited
        'limit' => 5,
        //Option to clear each copies text input fields or textarea
        'clearInputs' => true,
        //A jQuery selector used to exclude an element and its children
        'excludeSelector' => '.skipcopy',
    )
))
?>
<a id="copylink" href="#" rel=".copy">Copy</a>
<div class="copy">
    <?php echo CHtml::dropDownList('code[]', "string", Subcomponent::model()->getSubcomponentOptions(), array('prompt' => 'Pilih Paket Pekerjaan')); ?> 
    <?php echo CHtml::dropDownList('ppk_code[]', "string", Ppk::model()->getPpkOptions(), array('prompt' => 'Pilih PPK')); ?> </br>
    <?php echo CHtml::dropDownList('province_code[]', "string", Province::model()->getOptionsCodeName(), array('prompt' => 'Pilih Provinsi')); ?>
    <?php echo CHtml::dropDownList('city_code[]', "string", City::model()->getOptionsCodeName(), array('prompt' => 'Pilih Kab/Kota')); ?>
</div>
</br>
</br>
<div class="clearfix"></div>

