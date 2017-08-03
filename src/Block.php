<?php
namespace alf;

interface Block extends Element {
	/**
	 * Called by the parent container when appended to it
	 * @param \alf\Container $container
	 */
	public function setContainer($container);
	
	/**
	 * Sets a fixed height for this block
	 * @param number $height
	 * @return self
	 */
	public function setHeight($height);
	
	/**
	 * Returns the minimal height this element will consume
	 * @return number
	 */
	public function getMinimalHeight();
	
	/**
	 * Returns the calculated height this block will consume which could be a fixed value or dynamic value depending on its content
	 * @return number
	 */
	public function getCalulatedHeight();
}