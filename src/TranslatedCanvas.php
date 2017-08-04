<?php
namespace alf;

class TranslatedCanvas implements Canvas {
	/**
	 * 
	 * @var \alf\Canvas
	 */
	private $canvas;
	
	/**
	 * 
	 * @var number $left
	 * @var number $top
	 */
	private $left, $top;
	
	/**
	 * 
	 * @param \alf\Canvas $canvas
	 * @param number $left
	 * @param number $top
	 */
	public function __construct($canvas, $left, $top){
		$this->canvas	= $canvas;
		$this->left		= $left;
		$this->top		= $top;
	}
	
	public function setFillColor($color){
		$this->canvas->setFillColor($color);
	}
	
	public function setStrokeColor($color){
		$this->canvas->setStrokeColor($color);
	}
	
	public function setFont($name, $size){
		$this->canvas->setFont($name, $size);
	}
	
	public function setLineWidth($width){
		$this->canvas->setLineWidth($width);
	}
	
	public function setLineCap($style){
		$this->canvas->setLineCap($style);
	}
	
	public function setLineJoin($style){
		$this->canvas->setLineJoin($style);
	}
	
	public function save(){
		$this->canvas->save();
	}
	
	public function restore(){
		$this->canvas->restore();
	}
	
	public function fillRect($x, $y, $width, $height){
		$this->canvas->rectangle($x + $this->left, $y + $this->top, $width, $height);
	}
	
	public function strokeRect($x, $y, $width, $height){
		$this->canvas->rectangle($x + $this->left, $y + $this->top, $width, $height, false, true);
	}
	
	public function fillText($text, $x, $y){
		$this->canvas->fillText($text, $x + $this->left, $y + $this->top);
	}
	
	public function strokeText($text, $x, $y){
		$this->canvas->strokeText($text, $x + $this->left, $y + $this->top);
	}
	
	public function measureText($text){
		$this->canvas->measureText($text);
	}
	
	public function drawImage($image, $dx, $dy, $dWidth, $dHeight){
		$this->canvas->drawImage($image, $dx, $dy, $dWidth, $dHeight);
	}
	
	public function moveTo($x, $y){
		$this->canvas->moveTo($x + $this->left, $y + $this->top);
	}
	
	public function lineTo($x, $y){
		$this->canvas->lineTo($x + $this->left, $y + $this->top);
	}
	
	public function closePath(){
		$this->canvas->closePath();
	}
	
	public function fill(){
		$this->canvas->fill();
	}
	
	public function stroke(){
		$this->canvas->stroke();
	}
	
	public function clip(){
		$this->canvas->clip();
	}
	
	public function rotate($angle){
		$this->canvas->rotate($angle);
	}
	
	public function scale($x, $y){
		$this->canvas->scale($x, $y);
	}
	
	public function translate($x, $y){
		$this->canvas->translate($x, $y);
	}
	
	public function transform($hscale, $hskew, $vskew, $vscale, $dx, $dy){
		$this->canvas->transform($hscale, $hskew, $vskew, $vscale, $dx, $dy);
	}
}