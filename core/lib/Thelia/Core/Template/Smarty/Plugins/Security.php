<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia	                                                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*	    email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*	    along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/*************************************************************************************/

namespace Thelia\Core\Template\Smarty\Plugins;

use Thelia\Core\Template\Smarty\SmartyPluginDescriptor;
use Thelia\Core\Template\Smarty\SmartyPluginInterface;
use Thelia\Core\Template\Smarty\Assets\SmartyAssetsManager;
use Thelia\Core\Security\SecurityManager;

class Security implements SmartyPluginInterface
{
	private $securityManager;

	public function __construct(SecurityManager $securityManager)
	{
		$this->securityManager = $securityManager;
	}

	private function _explode($commaSeparatedValues)
	{

    	$array = explode(',', $commaSeparatedValues);

    	if (array_walk($array, function(&$item) {
   				$item = strtoupper(trim($item));
 			})) {
 			return $array;
 		}

 		return array();
	}

    /**
     * Process security check function
     *
     * @param  unknown $params
     * @param  unknown $smarty
     * @return string
     */
    public function checkAUth($params, &$smarty)
    {
   		$roles = $this->_explode($params['role']);
   		$permissions = $this->_explode($params['role']);

   		$this->securityManager->isGranted($roles, $permissions);

     }

    /**
     * Define the various smarty plugins hendled by this class
     *
     * @return an array of smarty plugin descriptors
     */
    public function getPluginDescriptors()
    {
        return array(
            new SmartyPluginDescriptor('function', 'check_auth', $this, 'checkAUth'),
        );
    }
}