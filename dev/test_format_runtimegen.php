<?php
	require('./init.php');
    
    class generator implements Opt_Generator_Interface
    {
    	private $_parent;
    	
    	public function __construct($parent = '')
    	{
    		$this->_parent = $parent;
    	} // end __construct();
    
    	public function generate($name)
    	{
    		$result = array();
    		for($i = 1; $i <= 3; $i++)
    		{
    			$val = $this->_parent.(string)$i;
    			switch($name)
    			{
    				case 'sect1':
    					$result[] = array('val' => $val, 'sect2' => new generator($val.'.'));
    					break;
    				case 'sect2':
    					$result[] = array('val' => $val, 'sect3' => new generator($val.'.'));
    					break;
    				case 'sect3':
    					$result[] = array('val' => $val);
    			}
    		}
    		return $result;
    	} // end generate();
    } // end Opt_Generator_Interface;
    
    try
    {
    	$tpl = new Opt_Class;
    	$tpl->sourceDir = './templates/';
    	$tpl->compileDir = './templates_c/';
    	$tpl->compileId = 'runtimeGen';
    	$tpl->charset = 'utf-8';
    	$tpl->compileMode = Opt_Class::CM_REBUILD;
    	$tpl->stripWhitespaces = false;
    	$tpl->setup();
    	
    	$view = new Opt_View('test_format_2.tpl');
    	$view->currentFormat = 'RuntimeGenerator';

    	if(rand(0,1) == 1)
    	{
	    	$view->sect1 = array(0 =>
	    		array(
	    			'val' => '1',
	    			'sect2' => 
		    		array(0 =>
		    			array('val' => '1.1', 'sect3' => array(0 =>
		    				array('val' => '1.1.1'),
		    				array('val' => '1.1.2'),
		    				array('val' => '1.1.3'),
		    			)),
		    			array('val' => '1.2', 'sect3' => array(0 =>
		    				array('val' => '1.2.1'),
		    				array('val' => '1.2.2'),
		    				array('val' => '1.2.3'),
		    			),
	    				),
		    			array('val' => '1.3')    		
		    		)
	    		),
	    		array('val' => '2'),
	    		array('val' => '3', 'sect2' => 
		    		array(0 =>
		    			array('val' => '3.1', 'sect3' => array(0 =>
		    				array('val' => '3.1.1'),
		    				array('val' => '3.1.2'),
		    				array('val' => '3.1.3'),
		    			)),
		    			array('val' => '3.2', 'sect3' => array(0 =>
		    				array('val' => '3.2.1'),
		    				array('val' => '3.2.2'),
		    				array('val' => '3.2.3'),
		    			),
	    				),
		    			array('val' => '3.3')    		
		    		),
	    		),
	    		array('val' => '4', 'sect2' => 
		    		array(0 =>
		    			array('val' => '4.1'),
		    			array('val' => '4.2'),
		    			array('val' => '4.3')    		
		    		)
	    		)  	
	    	);
    	}
    	else
    	{
    		$view->sect1 = new generator();
    	}
    	$view->setFormat('sect1', 'RuntimeGenerator/SingleArray');
		$view->setFormat('sect2', 'RuntimeGenerator/SingleArray');
		$view->setFormat('sect3', 'RuntimeGenerator/SingleArray');
    	$out = new Opt_Output_Http;
    	$out->render($view);
    }
    catch(Opt_Exception $e)
	{
		Opt_Error_Handler($e);
	}
?>
