<?php
	require('./init.php');
    
    try
    {
    	$tpl = new Opt_Class;
    	$tpl->sourceDir = './templates/';
    	$tpl->compileDir = './templates_c/';
    	$tpl->charset = 'utf-8';
    	$tpl->compileMode = Opt_Class::CM_REBUILD;
    	$tpl->stripWhitespaces = false;
    	$tpl->setup();
    	
    	$view = new Opt_View('test_cdata_1.tpl');
    	$view->assign('object', 'sunglasses');

		$out = new Opt_Output_Http;
		$out->setContentType(Opt_Output_Http::HTML);
		$out->render($view);
    }
    catch(Opt_Exception $exception)
    {
    	Opt_Error_Handler($exception);
    }
?>