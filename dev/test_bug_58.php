<?php
	require('./init.php');

    try
    {
    	$tpl = new Opt_Class;
    	$tpl->sourceDir = './templates/';
    	$tpl->compileDir = './templates_c/';
    	$tpl->charset = 'utf-8';
    	$tpl->compileMode = Opt_Class::CM_REBUILD;
    	$tpl->stripWhitespaces = true;
    	$tpl->setup();

    	$view = new Opt_View('test_bug_58.tpl');
    	$view->foo = 'A foo value';

    	$httpOutput = new Opt_Output_Http;
    	$httpOutput->setContentType(Opt_Output_Http::HTML);
    	$httpOutput->render($view);
    }
    catch(Opt_Exception $exception)
    {
    	Opt_Error_Handler($exception);
    }
    catch(Opl_Exception $exception)
    {
    	Opl_Error_Handler($exception);
    }
?>