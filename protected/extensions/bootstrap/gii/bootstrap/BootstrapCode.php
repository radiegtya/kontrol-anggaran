<?php

/**
 * BootstrapCode class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
Yii::import('gii.generators.crud.CrudCode');

class BootstrapCode extends CrudCode {

    public function generateActiveRow($modelClass, $column) {
        if ($column->type === 'boolean')
            return "\$form->checkBoxRow(\$model,'{$column->name}')";
        else if (stripos($column->dbType, 'text') !== false)
            return "\$form->textAreaRow(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50, 'class'=>'span8'))";
        else {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name))
                $inputField = 'passwordFieldRow';
            else
                $inputField = 'textFieldRow';

            if ($column->type !== 'string' || $column->size === null)
                return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span5'))";
            else
                return "\$form->{$inputField}(\$model,'{$column->name}',array('class'=>'span5','maxlength'=>$column->size))";
        }
    }

    public function getForeignKeyColumn($str) {
        $str = str_replace('_id', '', $str);
        $str = explode('_', $str);
        $result = '';
        for ($i = 0; $i < count($str); $i++) {
            if($i == 0)
                $result.= $str[$i];
            else
                $result.= ucfirst($str[$i]);
        }
        return $result;
    }
    
    public function getForeignKeyClass($str) {
        $str = str_replace('_id', '', $str);
        $str = explode('_', $str);
        $result = '';
        for ($i = 0; $i < count($str); $i++) {
            $result.= ucfirst($str[$i]);
        }
        return $result;
    }

}
