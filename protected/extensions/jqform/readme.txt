FULL DOCUMENTATION HERE
http://jquery.malsup.com/form/#ajaxSubmit
http://www.yiiframework.com/extension/jqform

1. add this to _form
<?php
$loadUrl = $this->createUrl('product/admin');

$this->widget('ext.jqform.JqForm', array(
    'formId' => 'product-form',
    'options' => array(
        'function'=>"$.fn.yiiGridView.update('product-grid');",
    ),
));
?>