<?php 
/**
* 
*/
class BaseController
{
	
	function render($file, $variables = array(), $layout = null) {

		$variables['viewPath'] = $file;

        extract($variables);

        ob_start();
        if($layout != null){
        	include_once $layout;
        }else{
        	include_once file;
        }
        $renderedView = ob_get_clean();

        return $renderedView;
    }
    
    public function redirect($path = ""){
        header('location: ' . getUrl($path));
    }
}



 ?>