<?php
/***************************************************************
 *  Copyright notice
 *  
 *  (c) 2007 Jens Mittag (jens.mittag@prime23.de)
 *  All rights reserved
 *
 *  This script is part of the Typo3 project. The Typo3 project is 
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 * 
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 * 
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
 
/** 
 * Plugin 'MathGuard' for the 'tx_mathguard' extension. 
 *
 * @author	Reinhard Führicht <rf@typoheads.at>
 */



class tx_mathguard {
	
	var $prefixId = 'tx_mathguard'; // Same as class name
	var $scriptRelPath = 'class.tx_mathguard.php'; // Path to this script relative to the extension dir.
	var $extKey = 'mathguard'; // The extension key.
	var $langFile = '';

	public function getCaptcha() {
		require_once(t3lib_extMgm::extPath('mathguard') . 'res/ClassMathGuard.php');
		$conf = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_mathguard.'];
		
		//Set question string
		if($conf['question']) {
			$question = $conf['question'];
		} else {
			$langFile = t3lib_extMgm::extPath('mathguard') . 'res/locallang.xml';
			$question = trim($GLOBALS['TSFE']->sL('LLL:' . $langFile . ':mathguard_question'));
		}
		
		//Set color of output
		if($conf['color']) {
			$color = $conf['color'];
		} else {
			$color = 'red';
		}
		
		return MathGuard::returnQuestion($question, $color);
	}
	
	
	public function validateCaptcha() {
		
		$valid = true;
		
		require_once(t3lib_extMgm::extPath('mathguard') . 'res/ClassMathGuard.php');
		if (!MathGuard::checkResult($_REQUEST['mathguard_answer'], $_REQUEST['mathguard_code'])) {
			$valid = false;
		}
		return $valid;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mathguard/class.tx_mathguard.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mathguard/class.tx_mathguard.php']);
}

?>
