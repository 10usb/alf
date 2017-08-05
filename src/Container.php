<?php
namespace alf;

interface Container extends Sliceable, Renderable {
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
}