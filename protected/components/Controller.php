<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout='//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu=array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs=array();
    
    public function filterCheckSig($filterChain)
    {   
        if ($this->checkSig()) {
            $filterChain->run();
        } else {
            throw new CException('Signature Error');
        }   
    }   

    public function signature($params) 
    {   
        if (array_key_exists('sig', $params)) unset($params['sig']);
        if (array_key_exists('r', $params)) unset($params['r']); 

        ksort($params);
        $newArray = array();
        foreach ($params as $key => $val) {
            $newArray[] = $key. '/' . $val;
        }   
        $string = implode('/', $newArray);
        return md5($string . 'news0123456789');
    }   

    public function checkSig()
    {   
        $params = $this->getActionParams();
        if (array_key_exists('sig', $params)) return $params['sig'] == $this->signature($params);
    }   

    public function getActionParams()
    {   
        return $_GET + $_POST;
    }   

    public function echoJson($data=array()) {
        echo CJSON::encode($data);
    }
}
