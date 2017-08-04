<?php
namespace alf;

interface Inline extends Element {
	const FLOAT_NONE	= 0;
	const FLOAT_LEFT	= 1;
	const FLOAT_RIGHT	= 2;
	
	const ALIGN_TOP		= 0;
	const ALIGN_MIDDLE	= 1;
	const ALIGN_BOTTOM	= 2;
	
	/**
	 * Called by the line to set offset from the begining of the line
	 * @param number $value
	 */
	public function setLineLeft($value);
	
	/**
	 * Returns the current left position on the line
	 * @param number $value
	 */
	public function getLineLeft();
	
	/**
	 * Called by the line to set offset from the top of the line
	 * @param number $value
	 */
	public function setLineTop($value);
	
	/**
	 * Returs the floating value of this inline element
	 * @return integer
	 */
	public function getFloating();
	
	/**
	 * Returns the vertical alignment of this inline element
	 * @return intger
	 */
	public function getVerticalAlignment();
}