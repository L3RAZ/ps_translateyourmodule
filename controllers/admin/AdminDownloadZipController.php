<?php
/**
 * 2007-2019 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */


use PrestaShop\Module\PsTranslateYourModule\Zip;
/**
* 2007-2019 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author PrestaShop SA <contact@prestashop.com>
* @copyright 2007-2019 PrestaShop SA
* @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
* International Registered Trademark & Property of PrestaShop SA
**/

class AdminDownloadZipController extends ModuleAdminController
{
    const SANDBOX_PATH = _PS_CACHE_DIR_.'sandbox/';

    /**
     * Construct initHeader
     * Redirect to module page configuration if error
     *
     * @return void
     */
    public function initHeader()
    {
        $moduleName = Tools::getValue('module_name');
        
        if (!$moduleName) {
            Tools::Redirect($this->module->getModulePageConfiguration(
                array('error_controller' => $this->module::FORM_ERROR_CODES['modulename'])
            ));
        }

        $archiveName = $moduleName . '_translations_' . date('ymdhis') . '.zip';
        $folderToZip = _PS_MODULE_DIR_ . $moduleName . '/translations/';

        $getZip = new Zip($archiveName, $folderToZip);
        
        if (false === $getZip->createZip()) {
            Tools::Redirect($this->module->getModulePageConfiguration(
                array('error_controller' => $this->module::FORM_ERROR_CODES['ziperror'])
            ));
        }

        $getZip->downloadZip();

        die();
    }
}
