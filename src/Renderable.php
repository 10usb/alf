<?php
namespace alf;

interface Renderable {
	/**
	 * Will get called to render this element
	 * @param \alf\Canvas $canvas
	 */
	public function render($canvas);
}