<?php
/*
 *  OPEN POWER LIBS <http://www.invenzzia.org>
 *
 * This file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE. It is also available through
 * WWW at this URL: <http://www.invenzzia.org/license/new-bsd>
 *
 * Copyright (c) Invenzzia Group <http://www.invenzzia.org>
 * and other contributors. See website for details.
 *
 * $Id$
 */

/**
 * A class for managing the CDF documents both by the programmer
 * and the compiler.
 */
class Opt_Cdf_Manager
{
	/**
	 * A search area
	 * @var array
	 */
	private $_information;

	/**
	 * The list of resolved data formats.
	 * @var array
	 */
	private $_resolved;

	/**
	 * The selected default locator.
	 * @var Opt_Cdf_Locator_Interface
	 */
	private $_locator;

	/**
	 * The list of available data formats.
	 * @var array
	 */
	private $_formats;

	/**
	 * The main template engine class.
	 * @var Opt_Class
	 */

	/**
	 * Creates a new CDF manager instance.
	 *
	 * @param array $formatList The list of data formats from the public API.
	 */
	public function __construct($tpl, array $formatList)
	{
		$this->_tpl = $tpl;
		$this->_formats = $formatList;
	} // end __construct();

	/**
	 * Sets the new default locator.
	 * 
	 * @param Opt_Cdf_Locator_Interface $locator The locator interface
	 */
	public function setLocator(Opt_Cdf_Locator_Interface $locator)
	{
		$this->_locator = $locator;
	} // end setLocator();

	/**
	 * Returns the data format for the specified element type. If the
	 * data format for the element is already cached, it returns the
	 * existing object. Otherwise, a new one is created.
	 *
	 * @param string $elementType The element type name
	 * @param string $id The element ID
	 * @param string $type The data format type name
	 * @param Opt_Cdf_Locator_Interface $locator The locator used to determine the element location.
	 */
	public function getFormat($elementType, $id, $type, $locator = null)
	{	
		if($locator === null)
		{
			$locator = $this->_locator;
		}

		$code = $elementType.':'.$id;

		// Maybe we have already solved this element?
		if(isset($this->_resolved[$code]))
		{
			if(isset($this->_resolved[$code][$type]))
			{
				return $this->_resolved[$code][$type];
			}
			elseif(isset($this->_resolved[$code]['generic']))
			{
				return $this->_resolved[$code]['generic'];
			}
		}

		$checkIn = array();
		// Determine, what elements to scan and in what order.
		if($elementType !== null && $id !== null)
		{
			$checkIn[] = $elementType.'#'.$id;
		}
		if($id !== null)
		{
			$checkIn[] = '#'.$id;
		}
		if($elementType !== null)
		{
			$checkIn[] = $elementType.'#';
		}

		if($type == 'generic')
		{
			$types = array('generic');
		}
		else
		{
			$types = array($type, 'generic');
		}

		$location = $locator->getElementLocation($elementType, $id);

		// Now look for the data format definition and process it.
		$match = null;
		foreach($checkIn as $key)
		{
			foreach($types as $checkedType)
			{
				if(!isset($this->_information[$checkedType]))
				{
					continue;
				}
				if(!isset($this->_information[$checkedType][$key]))
				{

					continue 2;
				}

				// Check each matching definition for the element against
				// the obtained location.
				foreach($this->_information[$checkedType][$key] as $definition)
				{
					$i = 0;
					// The path must match the element location
					// in order to select this definition
					foreach($definition['path'] as $pathItem)
					{
						if($location[$i] != $pathItem)
						{
							continue 2;
						}
						$i++;
					}
					$match = $definition;
					break 3;
				}
			}
		}
		if($match === null)
		{
			throw new Opt_NoMatchingFormat_Exception(reset($checkIn));
		}

		if(!isset($this->_resolved[$code]))
		{
			$this->_resolved[$code] = array();
		}

		return $this->_resolved[$code][$type] = $this->_createFormat(reset($checkIn), $match['format']);
	} // end getFormat();

	/**
	 * Registers a new format in the CDF manager for the specified item.
	 *
	 * @param string $elementType The type of element we want to have
	 * @param string $id The element identifier
	 * @param string $type The type of registered data format
	 * @param string $format The format itself
	 * @param array $fullyQualifiedPath The fully qualified path to the element
	 */
	public function addFormat($elementType, $id, $type, $format, array $fullyQualifiedPath)
	{
		if(!isset($this->_information[$type]))
		{
			$this->_information[$type] = array();
		}
		$row = array(
			'format' => $format,
			'path' => $fullyQualifiedPath
		);

		$insertTo = array();
		if($elementType !== null && $id !== null)
		{
			$insertTo[] = $elementType.'#'.$id;
		}
		elseif($elementType !== null)
		{
			$insertTo[] = $elementType.'#';
		}
		elseif($id !== null)
		{
			$insertTo[] = '#'.$id;
		}
		foreach($insertTo as $key)
		{
			if(!isset($this->_information[$type][$key]))
			{
				$this->_information[$type][$key] = new SplPriorityQueue;
			}
			$this->_information[$type][$key]->insert(&$row, sizeof($fullyQualifiedPath));
		}
	} // end addFormat();

	/**
	 * Creates a format object for the specified description string.
	 *
	 * @param String $key The element key.
	 * @param String $hc The description string.
	 * @return Opt_Compiler_Format The newly created format object.
	 */
	protected function _createFormat($key, $hc)
	{
		// Decorate the objects, if necessary
		$expanded = explode('/', $hc);
		$obj = null;
		foreach($expanded as $class)
		{
			if(!isset($this->_formats[$class]))
			{
				throw new Opt_FormatNotFound_Exception($key, $class);
			}
			$hcName = $this->_formats[$class];
			if($obj !== null)
			{
				$obj->decorate($obj2 = new $hcName($this->_tpl, $this));
				$obj = $obj2;
			}
			else
			{
				$top = $obj = new $hcName($this->_tpl, $this, $hc);
			}
		}
		return $top;
	} // end _createFormat();
} // end Opt_Cdf_Manager;