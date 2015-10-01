<table class="table-bordered appendo-gii" id="<?php echo $id ?>" style="color:  black">
    <thead>
        <tr>
            <th>Kode Paket </th>
            <th>PPK</th>
            <th>Provinsi</th>
            <th>Kota</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($model->code == null): ?>
            <tr>
                <td><?php echo CHtml::dropDownList('code[]', "string", Subcomponent::model()->getNonUsedOnPackage(), array('prompt' => 'Pilih','class'=>'code')); ?> </td>
                <td><?php echo CHtml::dropDownList('ppk_code[]', "string", Ppk::model()->getPpkOptions(), array('prompt' => 'Pilih')); ?> </td>
                <td><?php echo CHtml::dropDownList('province_code[]', "string", Province::model()->getOptionsCodeName(), array('prompt' => 'Pilih')); ?> </td>
                <td><?php echo CHtml::dropDownList('city_code[]', "string", City::model()->getOptionsCodeName(), array('prompt' => 'Pilih')); ?> </td>
            </tr>
        <?php else: ?>
            <?php for ($i = 0; $i < sizeof($model->code); ++$i): ?>
                <tr>
                    <td><?php echo CHtml::dropDownList('code[]', "string", Subcomponent::model()->getSubcomponentOptions(), array('prompt' => 'Pilih')); ?> </td>
                    <td><?php echo CHtml::dropDownList('ppk_code[]', "string", Ppk::model()->getPpkOptions(), array('prompt' => 'Pilih')); ?> </td>
                    <td><?php echo CHtml::dropDownList('province_code[]', "string", Province::model()->getOptionsCodeName(), array('prompt' => 'Pilih')); ?> </td>
                    <td><?php echo CHtml::dropDownList('city_code[]', "string", City::model()->getOptionsCodeName(), array('prompt' => 'Pilih')); ?> </td>
                </tr>
            <?php endfor; ?>
            <tr>
                <td><?php echo CHtml::dropDownList('code[]', "string", Subcomponent::model()->getSubcomponentOptions(), array('prompt' => 'Pilih')); ?> </td>
                <td><?php echo CHtml::dropDownList('ppk_code[]', "string", Ppk::model()->getPpkOptions(), array('prompt' => 'Pilih')); ?> </td>
                <td><?php echo CHtml::dropDownList('province_code[]', "string", Province::model()->getOptionsCodeName(), array('prompt' => 'Pilih')); ?> </td>
                <td><?php echo CHtml::dropDownList('city_code[]', "string", City::model()->getOptionsCodeName(), array('prompt' => 'Pilih')); ?> </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
