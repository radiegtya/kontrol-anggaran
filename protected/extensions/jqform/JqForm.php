<?php

/**
 * JqForm class file.
 *
 * @author Mark van den Broek (mark@heyhoo.nl)
 * @link http://yii.heyhoo.com/jqform/  
 * @copyright Copyright &copy; 2010 HeyHoo
 *
 *  The following example shows how to use JqForm:
 * <pre>
 * $this->widget('application.extensions.jqform.JqForm', array(
 *     'formId' => 'myForm', 
 *     'options' => array( 
 *         'function' => 'alert("Thank you!");', 
 *     ), 
 * ));
 * </pre>
 */

class JqForm extends CWidget
{
    public $formId;
    public $options=array();

    private $nljs;
	  private $baseUrl;
    private $clientScript;
    
    private $needEscape = array('url','target','type','dataType');

    public function init()
    {
        if ($this->formId == '')
           $this->formId = $this->getId();

        $this->nljs = "\n";
        $this->options=$this->normalizeOptions($this->options);
        parent::init();
    }

    /**
     * normalize options
     */
	  protected function normalizeOptions($options)
	  {
				foreach($options as $i=>$option)
				{
					  if ($i == 'target' && $option[0] != '#')
					  		$options[$i] = $option = '#'.$option;
        		if (in_array($i,$this->needEscape))
								$options[$i] = $this->escapeString($option);
				}
    
    		return $options;
    }
    
    /**
     * The javascript needed
     */
    protected function createJsCode()
    {
        $options = $this->createJsOptions($this->options);
        $js  = '';
        $js .= '$(document).ready(function() {' . $this->nljs;
        $js .= '   var options = '.$options.';' . $this->nljs;
        $js .= '   $("#'.$this->formId.'").ajaxForm( options );' . $this->nljs;
        $js .= '});';
        return $js;
    }    
    
     /**
     * The options needed
     */
    protected function createJsOptions($options)
    {
    		$js = '';

			  foreach($options as $key => $value) {
			      if ($key=='function')
			        return 'function() {'.$value.'}';
			      else
			        $js .= $key.': '.$value.',';
			  }
			  $js = substr($js, 0, -1);
			  $js = '{'.$js.'}';

    		return $js;
    }  
    
     /**
     * escape a string
     */
    protected function escapeString($str)
    {
        return "'".$str."'";    
    }
    
    /**
    * Publishes the assets
    */
    public function publishAssets()
    {
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'source';
        $this->baseUrl = Yii::app()->getAssetManager()->publish($dir);
    }

    /**
    * Registers the external javascript files
    */
    public function registerClientScripts()
    {
        // add the scripts
        if ($this->baseUrl === '')
            throw new CException(Yii::t('JqForm', 'baseUrl must be set. This is done automatically by calling publishAssets()'));

        $this->clientScript = Yii::app()->getClientScript();
        $this->clientScript->registerCoreScript('jquery');
        $this->clientScript->registerScriptFile($this->baseUrl.'/jquery.form.js');
    }

    /**
     * Run the widget
     */
    public function run()
    {
        $this->publishAssets();
        $this->registerClientScripts();

        $js = $this->createJsCode();
        $this->clientScript->registerScript('jqform_'.$this->getId(), $js, CClientScript::POS_HEAD);
        
        parent::run();
    }
}