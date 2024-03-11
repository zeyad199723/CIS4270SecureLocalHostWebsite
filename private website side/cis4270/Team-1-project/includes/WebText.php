<?php
/**
 * Class of methods for making text ready for output on web pages in the guitarShop application.
 *
 * @author JAM
 * @version 2110306
 */
class WebText {
	
	/**
	 * Adds paragraph and unordered list HTML tags to a block of text
	 * @param string $textInput the text to which the HTML tages must be added
	 * @return string the text with the HTML tags added
	 */
	public static function addTags($textInput) {

		// Convert return characters to the Unix new lines
		// Convert for Windows first, then for Mac
		$textWindows = str_replace ( "\r\n", "\n", $textInput );
		$textUnix = str_replace ( "\r", "\n", $textWindows );

		// Get an array of paragraphs
		$paragraphs = explode ( "\n\n", $textUnix );

		// Add tags to each paragraph
		$text = '';
		foreach ( $paragraphs as $p ) {
			$p = ltrim ( $p );

			$first_char = substr ( $p, 0, 1 );
			if ($first_char == '*') {
				// Add <ul> and <li> tags
				$p = '<ul>' . $p . '</li></ul>';
				$p = str_replace ( "*", '<li>', $p );
				$p = str_replace ( "\n", '</li>', $p );
			} else {
				// Add <p> tags
				$p = '<p>' . $p . '</p>';
			}
			$text .= $p;
		}

		return $text;
	}
	
	/**
	 * Adds paragraph and unordered list HTML tags to a block of text and returns only the first paragraph.
	 * @param string $textInput the text to which the HTML tages must be added
	 * @return string the first paragraph of the text with the HTML tags added
	 */
	public static function getFirstParagraph($textInput) {
		$descriptionWithTags = self::addTags($textInput);
		$i = strpos($descriptionWithTags, "</p>");
		return substr($descriptionWithTags, 3, $i - 3);
	}
}

