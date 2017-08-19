<?php
namespace alf;

interface Container extends Sliceable, Packable, Renderable {
	/**
	 *
	 * @param \alf\Block $element
	 * @return \alf\Block
	 */
	public function appendBlock($element);
	
	/**
	 *
	 * @param \alf\Inline $element
	 * @return \alf\Inline
	 */
	public function appendInline($element);
	
	/**
	 * 
	 * @param string $text
	 * @param array $style
	 */
	public function appendText($text, $font, $color, $lineHeight = false, $style = []);
	
	/**
	 * Returns the widht of the content
	 * @return number
	 */
	public function getContentWidth();
	
	/**
	 * Returns the calculated height this block will consume which could be a fixed value or dynamic value depending on its content
	 * @return number
	 */
	public function getCalulatedHeight();
}