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
 * $Id: Buffer.php 22 2008-12-03 11:32:29Z zyxist $
 */

 /*
  * This file provides an implementation of basic code buffer for all XML nodes.
  * The buffer allows to insert some PHP code in some predefined areas.
  */

	function OptPushArray(&$array, $from, $cnt = null)
	{
		if(!isset($array[$from]))
		{
			return;
		}
		$i = 0;
		if(is_null($cnt))
		{
			$cnt = sizeof($array);
			while($cnt > 0 && $from != $i)
			{
				if(isset($array[$i]))
				{
					$cnt--;
				}
				$i++;
			}
		}
		
		$tmp = $tmp2 = null;
		while($cnt > 0)
		{
			if(isset($array[$i]))
			{
				if(is_null($tmp))
				{
					$tmp = $array[$i];
				}
				else
				{
					$tmp2 = $array[$i];
					$array[$i] = $tmp;
					$tmp = $tmp2;
				}
				$cnt--;
			}
			$i++;
		}
		if(!is_null($tmp))
		{
			$array[$i] = $tmp;
		}
	} // end OptPushArray();

	abstract class Opt_Xml_Buffer
	{
		const TAG_BEFORE = 0;
		const TAG_AFTER = 1;
		const TAG_OPENING_BEFORE = 2;
		const TAG_OPENING_AFTER = 3;
		const TAG_CLOSING_BEFORE = 4;
		const TAG_CLOSING_AFTER = 5;
		const TAG_CONTENT_BEFORE = 6;
		const TAG_CONTENT_AFTER = 7;
		const TAG_CONTENT = 17;	// For private use only
		
		const TAG_SINGLE_BEFORE = 18;
		const TAG_SINGLE_AFTER = 19;
		
		const TAG_NAME = 8;
		const TAG_ATTRIBUTES_BEFORE = 9;
		const TAG_ATTRIBUTES_AFTER = 10;
		const TAG_BEGINNING_ATTRIBUTES = 11;
		const TAG_ENDING_ATTRIBUTES = 12;
		const ATTRIBUTE_BEGIN = 13;
		const ATTRIBUTE_END = 14;
		const ATTRIBUTE_NAME = 15;
		const ATTRIBUTE_VALUE = 16;
		
		protected $_buffers;
		protected $_hidden = NULL;
		protected $_args = null;
		
		public function addAfter($buffer, $code)
		{
			if(!is_array($this->_buffers))
			{
				$this->_buffers = array();
			}
			if(!isset($this->_buffers[$buffer]))
			{
				$this->_buffers[$buffer] = array();
			}
			
			$this->_buffers[$buffer][] = $code;
		} // end addAfter();
		
		public function addBefore($buffer, $code)
		{
			if(!is_array($this->_buffers))
			{
				$this->_buffers = array();
			}
			if(!isset($this->_buffers[$buffer]))
			{
				$this->_buffers[$buffer] = array();
			}
			
			array_unshift($this->_buffers[$buffer], $code);
		} // end addBefore();
		
		public function copyBuffer(Opt_Xml_Buffer $from, $fromTag, $toTag)
		{
			if(!is_array($this->_buffers))
			{
				$this->_buffers = array();
			}
			if(!isset($this->_buffers[$toTag]))
			{
				$this->_buffers[$toTag] = $from->getBuffer($fromTag);
			}
			else
			{		
				$this->_buffers[$toTag] = array_merge($from->getBuffer($fromTag), $this->_buffers[$toTag]);
			}
		} // end copyBuffer();
		
		public function getBuffer($buffer)
		{
			if(!is_array($this->_buffers))
			{
				return array();
			}
			if(!isset($this->_buffers[$buffer]))
			{
				return array();
			}
			return $this->_buffers[$buffer];
		} // end getBuffer();
		
		public function bufferSize($buffer)
		{
			if(!is_array($this->_buffers))
			{
				return 0;
			}
			if(!isset($this->_buffers[$buffer]))
			{
				return 0;
			}
			return sizeof($this->_buffers[$buffer]);
		} // end bufferSize();
		
		public function buildCode()
		{
			if(!is_array($this->_buffers))
			{
				return '';
			}

			$list = func_get_args();

			$out = '';
			$used = false;
			foreach($list as $item)
			{
				if(is_string($item))
				{
					if($used)
					{
						$out .= ' echo \''.$item.'\'; ';
					}
					$used = false;
					continue;
				}
				if(isset($this->_buffers[$item]))
				{
					if(sizeof($this->_buffers[$item]) > 0)
					{
						$out .= implode(' ', $this->_buffers[$item]).' ';
						$used = true;
					}
				}
				else
				{
					$used = false;
				}
			}

			if(strlen($out) > 0)
			{
				return ($this->get('nophp') ? trim($out) : '<'.'?php '.$out.' ?'.'>');
			}
			return '';
		} // end buildCode();
		
		public function clear($buffer = NULL)
		{
			if(is_null($buffer))
			{
				$this->_buffers = null;
			}
			elseif(is_array($this->_buffers) && isset($this->_buffers[$buffer]))
			{
				unset($this->_buffers[$buffer]);
			}
		} // end clear();
		
		public function set($name, $value)
		{
			if($name == 'hidden')
			{
				$this->_hidden = $value;
				return;
			}
			if(!is_array($this->_args))
			{
				$this->_args = array($name => $value);
			}
			else
			{
				$this->_args[$name] = $value;
			}
		} // end set();
		
		public function get($name)
		{
			if($name == 'hidden')
			{
				return $this->_hidden;
			}
			if(!is_array($this->_args) || !isset($this->_args[$name]))
			{
				return null;
			}
			return $this->_args[$name];
		} // end get();
	} // end Opt_Xml_Buffer;
