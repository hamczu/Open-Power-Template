<?php
	require('./init.php');

	try
	{
		$tpl= new Opt_Class;
		$tpl->sourceDir = './templates/';
		$tpl->compileDir = './templates_c/';
		$tpl->stripWhitespaces = false;
		$tpl->printComments = true;
		$tpl->contentNegotiation = true;
		$tpl->compileMode = Opt_Class::CM_REBUILD;
		$tpl->setup();
		
		$view = new Opt_View('test_attribute_1.tpl');
		
		$view->assign('attrName', 'class');
		$view->assign('attrValue', 'dude');
		
		$out = new Opt_Output_Http;
		$out->setContentType(Opt_Output_Http::XHTML);
		$out->render($view);
	}
	catch(Opt_Exception $e)
	{
		Opt_Error_Handler($e);
	}
?>