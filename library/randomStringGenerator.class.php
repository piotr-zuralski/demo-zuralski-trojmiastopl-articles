<?php
/**
 * randomStringGenerator.php
 *
 * Class that generates strings from random characters with specified length
 *
 * @author		Piotr Żuralski <piotr@zuralski.net>
 * @package		Demo.library
 * @version		$Revision:  $
 */
class randomStringGenerator {

	/**
	 * Return random string with specified length
	 * 
	 * @param integer $iLength
	 * @return string
	 */
	public function genRandomString($iLength = 200) {
		$iLength = (integer)$iLength;
		$iLength = ((!empty($iLength)) ? $iLength : 200);

		$sCharacters  = 'abcdefghi jklmnopqr stuvwxyz';
		$sCharacters .= ' 0123456789';
		$sCharacters .= ' ABCDEFGHI JKLMNOPQR STUXYVWZ';
		$sCharacters .= ' +-*#&@!?"';
		$iCharactersLength = mb_strlen($sCharacters)-1;

		$sReturn = '';
		for ($i = 0; $i < $iLength;) {
			$sReturn .= $sCharacters[mt_rand(0, $iCharactersLength)];
			++$i;
		}
		return $sReturn;
	}
}
