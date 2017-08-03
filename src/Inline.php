<?php
namespace alf;

interface Inline extends Element {
	/**
	 * 
	 * @param \alf\Line $line
	 */
	public function setLine($line);
	public function setLeft();
	public function setTop();
	public function getFloating();
}