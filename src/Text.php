<?php
namespace alf;

class Text implements Inline {
	/**
	 * 
	 * @var string
	 */
	private $value;
	
	/**
	 * 
	 * @var \alf\Font
	 */
	private $font;
	
	/**
	 * 
	 * @var string
	 */
	private $color;
	
	/**
	 * 
	 * @var number
	 */
	private $lineHeight;
	
	/**
	 * 
	 * @var number $lineLeft
	 * @var number $lineTop
	 */
	private $lineLeft, $lineTop;
	
	/**
	 * 
	 * @param string $value
	 * @param \alf\Font $font
	 * @param string $color
	 * @param number $lineHeight
	 */
	public function __construct($value, $font, $color, $lineHeight = false, $style = []){
		$this->value		= $value;
		$this->font			= $font;
		$this->color		= $color;
		$this->lineHeight	= $lineHeight;
		$this->lineLeft		= 0;
		$this->lineTop		= 0;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Inline::setLineLeft()
	 */
	public function setLineLeft($value){
		$this->lineLeft = $value;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Inline::getLineLeft()
	 */
	public function getLineLeft(){
		return $this->lineLeft;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Inline::setLineTop()
	 */
	public function setLineTop($value){
		$this->lineTop = $value;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Inline::getFloating()
	 */
	public function getFloating(){
		return Inline::FLOAT_NONE;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Inline::getVerticalAlignment()
	 */
	public function getVerticalAlignment(){
		return Inline::ALIGN_MIDDLE;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Element::getMarginLeft()
	 */
	public function getMarginLeft(){
		return 0;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Element::getMarginTop()
	 */
	public function getMarginTop(){
		return 0;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Element::getMarginRight()
	 */
	public function getMarginRight(){
		return 0;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Element::getMarginBottom()
	 */
	public function getMarginBottom(){
		return 0;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Element::getWidth()
	 */
	public function getWidth(){
		return $this->font->getTextWith($this->value);
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Element::getHeight()
	 */
	public function getHeight(){
		if($this->lineHeight!==false) return max($this->lineHeight, $this->font->getSize());
		return $this->font->getSize();
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Renderable::render()
	 */
	public function render($canvas){
		$canvas->setFont($this->font->getName(), $this->font->getSize());
		$canvas->setFillColor($this->color);
		$canvas->fillText($this->value, $this->lineLeft, $this->lineTop + $this->font->getSize() * 0.8575);
	}
}