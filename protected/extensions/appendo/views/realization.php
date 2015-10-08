<table class="table-bordered appendo-gii" id="<?php echo $id ?>" style="color:  black">
    <thead>
        <tr>
            <th>Kode Akun Paket </th>
            <th>Total SPM</th>
            <th>Nomor SPM</th>
            <th>Tanggal SPM</th>
            <th>UP/LS</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($model->packageAccount_code == null): ?>
            <tr>
                <td><?php echo CHtml::dropDownList('packageAccount_code[]', "string", PackageAccount::model()->getOptionsCodeName(), array('prompt' => 'Pilih', 'type' => 'selc', 'onfocus' => 'removeDuplicate()')); ?> </td>
                <td><?php echo CHtml::textField('total_spm[]'); ?> </td>
                <td><?php echo CHtml::textField('spm_number[]'); ?> </td>
                <!--date picker belum nemu naroh chtml nya-->
                <td><?php echo CHtml::textField('spm_date[]', '', array('placeholder' => "format:yyyy-mm-dd, ex:2015-08-30")); ?> </td>
                <!--date picker belum nemu naroh chtml nya-->
                <td width="60px"><?php echo CHtml::dropDownList('up_ls[]', 'string', array('UP' => 'UP', 'LS' => 'LS'), array('options' => array())); ?> </td>
            </tr>
        <?php else: ?>
            <?php for ($i = 0; $i < sizeof($model->packageAccount_code); ++$i): ?>
                <tr>
                </tr>
            <?php endfor; ?>
            <tr>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
    var removeDuplicate = function() {        
        $("select[type='selc']").find("option").each(function() {
            var val = $(this).val();
            var flag = false;

            if (!$(this).attr('selected')) {
                $("select[type='selc']").find("option:selected").each(function(){
                    if ($(this).val() == val){
                        flag = true;
                        return;
                    }
                });
            }

            if (flag)
                $(this).hide();
            else
                $(this).show();
        })
    }
</script>