<?php
/*
 *  OPEN POWER LIBS <http://libs.invenzzia.org>
 *  ===========================================
 *
 * This file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE. It is also available through
 * WWW at this URL: <http://www.invenzzia.org/license/new-bsd>
 *
 * Copyright (c) 2008 Invenzzia Group <http://www.invenzzia.org>
 * and other contributors. See website for details.
 *
 * $Id: Root.php 18 2008-10-29 21:23:43Z zyxist $
 */

 /*
  * XML tree root node.
  */

	class Opt_Xml_Root extends Opt_Xml_Scannable
	{
		private $_prolog = NULL;
		private $_dtd = NULL;

		public function __construct()
		{
			/* null */
		} // end __construct();
		
		public function setParent($parent)
		{
			/* null */
		} // end setParent();

		public function setProlog(Opt_Xml_Prolog $prolog)
		{
			$this->_prolog = $prolog;
		} // end setProlog();

		public function setDtd(Opt_Xml_Dtd $dtd)
		{
			$this->_dtd = $dtd;
		} // end setDtd();

		public function getProlog()
		{
			return $this->_prolog;
		} // end getProlog();

		public function getDtd()
		{
			return $this->_dtd;
		} // end getDtd();

		protected function _testNode(Opt_Xml_Node $node)
		{
			if($node->getType() != 'Opt_Xml_Expression' && $node->getType() != 'Opt_Xml_Cdata')
			{
				throw new Opt_APIInvalidNodeType_Exception('Opt_Xml_Root', $node->getType());
			}
		} // end _testNode();
	} // end Opt_Xml_Root;
