<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
 <head>
  <title>Test: translation interfaces 1</title>
 </head>
 <body>
  <h1>Test: translation interfaces 1</h1>
  <p>This file is used to test the translation interfaces.</p>
  
  <p>{$foo@bar}</p>
  <p>{$foo@joe}</p>

  {assign($goo@bar, $foo)}

  <p>{$goo@bar}</p>
 </body>
</html>