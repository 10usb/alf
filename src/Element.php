<?php
namespace alf;

interface Element extends Renderable {
	public function getMarginLeft();
	public function getMarginTop();
	public function getMarginRight();
	public function getMarginBottom();
	public function getWidth();
	public function getHeight();
}