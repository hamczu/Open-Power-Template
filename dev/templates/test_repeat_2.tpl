<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
 <head>
  <title>Test: Repeat 2</title>
 </head>
 <body>
  <h1>Test: Repeat 2</h1>
  <p>"opt:repeat" instruction tests.</p>
  <p>Check, how the nested instructions behave.</p>
  
  <opt:repeat times="5">
  	<p><strong>This is an order: {$opt.repeat.order}</strong></p>
  	<opt:repeat times="3">
  		<p>This is an suborder: {$opt.repeat.order}</p>
  	</opt:repeat>
  	<p><strong>End of the order: {$opt.repeat.order}</strong></p>
  </opt:repeat>
 </body>
</html>