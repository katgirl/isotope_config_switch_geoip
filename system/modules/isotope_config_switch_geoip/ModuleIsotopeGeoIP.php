<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Kirsten Roschanski 2012
 * @author     Kirsten Roschanski
 * @license    LGPL
 */

class ModuleIsotopeGeoIP extends ModuleIsotope
{

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{	
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ISOTOPE ECOMMERCE: STORE CONFIG SWICHER GEOIP ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		return parent::generate();
	}
	
	/**
	 * Compile the module
	 * @return void
	 */
	protected function compile()
	{
		$this->import('Isotope');
		$arrConfigs = array();
		$objConfigs = $this->Database->execute("SELECT * FROM tl_iso_config");
		
		while ($objConfigs->next())
		{
			$arrConfigs[$objConfigs->tld] = $objConfigs->id;
		}
		
		$country_name = apache_note("GEOIP_COUNTRY_CODE");

		$shop_id = $arrConfigs[$country_name];
		
    if( $_SESSION['ISOTOPE']['config_id'] != $shop_id)
    {
				$_SESSION['ISOTOPE']['config_id'] = $shop_id;

			$this->redirect($this->Environment->request);
    }		
		
	}	
	
}
