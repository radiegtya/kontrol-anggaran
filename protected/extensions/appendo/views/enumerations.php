<table class="appendo-gii" id="<?php echo $id ?>">
	<caption>
	Input list for constants
	</caption>
	<thead>
		<tr>
			<th>Name of constant</th>
            <th>Value</th>
            <th>Type</th>
            <th>Comment</th>
		</tr>
	</thead>
	<tbody>
    <?php if ($model->enum_name == null): ?>
		<tr>
			<td><?php echo CHtml::textField('enum_name[]','',array('style'=>'width:120px')); ?></td>
            <td><?php echo CHtml::textField('enum_value[]','',array('style'=>'width:90px')); ?></td>
            <td>
            <?php echo CHtml::dropDownList('enum_type[]',"string",
                array(
                    "string"=>"String",
                    "int"=>"Numeric",
                ),array('style'=>'width:100px')
                );
            ?>
            </td>
            <td><?php echo CHtml::textField('enum_comment[]','',array('style'=>'width:310px')); ?></td>
		</tr>
    <?php else: ?>
        <?php for($i = 0; $i < sizeof($model->enum_name); ++$i): ?>
    		<tr>
    			<td><?php echo CHtml::textField('enum_name[]',$model->enum_name[$i],array('style'=>'width:120px')); ?></td>
                <td><?php echo CHtml::textField('enum_value[]',$model->enum_value[$i],array('style'=>'width:90px')); ?></td>
                <td>
                <?php echo CHtml::dropDownList('enum_type[]',$model->enum_type[$i],
                    array(
                        "string"=>"String",
                        "int"=>"Numeric",
                    ),array('style'=>'width:100px')
                    );
                ?>
                </td>
                <td><?php echo CHtml::textField('enum_comment[]',$model->enum_comment[$i],array('style'=>'width:310px')); ?></td>
    		</tr>
        <?php endfor; ?>
		<tr>
			<td><?php echo CHtml::textField('enum_name[]','',array('style'=>'width:120px')); ?></td>
            <td><?php echo CHtml::textField('enum_value[]','',array('style'=>'width:90px')); ?></td>
            <td>
            <?php echo CHtml::dropDownList('enum_type[]',"string",
                array(
                    "string"=>"String",
                    "int"=>"Numeric",
                ),array('style'=>'width:100px')
                );
            ?>
            </td>
            <td><?php echo CHtml::textField('enum_comment[]','',array('style'=>'width:310px')); ?></td>
		</tr>
    <?php endif; ?>
	</tbody>
</table>