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
 * $Id: Class.php 269 2009-11-27 10:59:46Z zyxist $
 */

/**
 * The interface for locating elements in the CDF manager.
 */
interface Opt_Cdf_Locator_Interface
{
	public function getElementLocation($elementType, $id);
} // end Opt_Cdf_Locator_Interface;