<?php
namespace alf;

class Section implements Block, Inline, Container {
	const BORDER_BOX	= 1;
	const CONTENT_BOX	= 2;
	
	/**
	 *
	 * @var number
	 */
	private $width;
	
	/**
	 * 
	 * @var number
	 */
	private $preferredHeight;
	
	/**
	 *
	 * @var \alf\Container
	 */
	private $contents;
	
	/**
	 * 
	 * @var integer
	 */
	private $box;
	
	/**
	 *
	 * @var array
	 */
	private $style;
	
	/**
	 *
	 * @var number $lineLeft
	 * @var number $lineTop
	 */
	private $lineLeft, $lineTop;
	
	/**
	 * 
	 * @param number $width
	 * @param array $style
	 * @param integer $box
	 */
	public function __construct($width, $style = [], $box = self::BORDER_BOX){
		$this->style			= $style;
		$this->box				= $box;
		$this->lineLeft			= 0;
		$this->lineTop			= 0;
		$this->preferredHeight	= 0;
		
		if($box == self::BORDER_BOX){
			$this->width	= $width;
			if(isset($this->style['padding-left'])) $width-= $this->style['padding-left'];
			if(isset($this->style['padding-right'])) $width-= $this->style['padding-right'];
			if(isset($this->style['border-left'])) $width-= $this->style['border-left'];
			if(isset($this->style['border-right'])) $width-= $this->style['border-right'];
			$this->contents = new Body($width);
		}elseif($box == self::CONTENT_BOX){
			$this->contents = new Body($width);
			if(isset($this->style['padding-left'])) $width+= $this->style['padding-left'];
			if(isset($this->style['padding-right'])) $width+= $this->style['padding-right'];
			if(isset($this->style['border-left'])) $width+= $this->style['border-left'];
			if(isset($this->style['border-right'])) $width+= $this->style['border-right'];
			$this->width	= $width;
		}else{
			throw new \Exception('Invalid box model');
		}
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
		return $this->style['floating'] ?? Inline::FLOAT_NONE;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Inline::getVerticalAlignment()
	 */
	public function getVerticalAlignment(){
		return $this->style['vertical-alignment'] ?? Inline::ALIGN_MIDDLE;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Element::getMarginLeft()
	 */
	public function getMarginLeft(){
		return $this->style['margin-left'] ?? 0;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Element::getMarginTop()
	 */
	public function getMarginTop(){
		return $this->style['margin-top'] ?? 0;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Element::getMarginRight()
	 */
	public function getMarginRight(){
		return $this->style['margin-right'] ?? 0;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Element::getMarginBottom()
	 */
	public function getMarginBottom(){
		return $this->style['margin-bottom'] ?? 0;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Element::getWidth()
	 */
	public function getWidth(){
		return $this->width;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Element::getHeight()
	 */
	public function getHeight(){
		return max($this->preferredHeight, $this->getCalulatedHeight());
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Block::setPreferredHeight()
	 */
	public function setPreferredHeight($height){
		$this->preferredHeight = $height;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Sliceable::getMinimalHeight()
	 */
	public function getMinimalHeight(){
		$height = $this->contents->getMinimalHeight();
		
		if(isset($this->style['padding-top'])) $height+= $this->style['padding-top'];
		if(isset($this->style['padding-bottom'])) $height+= $this->style['padding-bottom'];
		if(isset($this->style['border-top'])) $height+= $this->style['border-top'];
		if(isset($this->style['border-bottom'])) $height+= $this->style['border-bottom'];
		
		return $height;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Block::getCalulatedHeight()
	 */
	public function getCalulatedHeight(){
		$height = $this->contents->getCalulatedHeight();
		
		if(isset($this->style['padding-top'])) $height+= $this->style['padding-top'];
		if(isset($this->style['padding-bottom'])) $height+= $this->style['padding-bottom'];
		if(isset($this->style['border-top'])) $height+= $this->style['border-top'];
		if(isset($this->style['border-bottom'])) $height+= $this->style['border-bottom'];
		
		return $height;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Container::appendBlock()
	 */
	public function appendBlock($element){
		return $this->contents->appendBlock($element);
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Container::appendInline()
	 */
	public function appendInline($element){
		return $this->contents->appendInline($element);
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Container::appendText()
	 */
	public function appendText($text, $font, $color, $lineHeight = false, $style = []){
		$this->contents->appendText($text, $font, $color, $lineHeight, $style);
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Container::getContentWidth()
	 */
	public function getContentWidth(){
		return $this->contents->getContentWidth();
	}
	
	/**
	 * TODO inpliment this method
	 * {@inheritDoc}
	 * @see \alf\Sliceable::slice()
	 */
	public function slice($height){
		throw new \Exception('Not implimented');
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Renderable::render()
	 */
	public function render($canvas){
		$left	= 0;
		$top	= 0;
		if(isset($this->style['border-left'])) $left+= $this->style['border-left'];
		if(isset($this->style['border-top'])) $top+= $this->style['border-top'];
		
		$width	 = $this->width - $left;
		$height	 = $this->getHeight() - top;
		if(isset($this->style['border-right'])) $width-= $this->style['border-right'];
		if(isset($this->style['border-bottom'])) $height-= $this->style['border-bottom'];
		
		
		if(isset($this->style['background-color'])){
			$canvas->setFillColor($this->style['background-color']);
			$canvas->fillRect($left, $top, $width, $height);
		}
		
		
		if(isset($this->style['padding-left'])) $left+= $this->style['padding-left'];
		if(isset($this->style['padding-top'])) $top+= $this->style['padding-top'];
		$this->contents->render(new TranslatedCanvas($canvas, $left, $top));
	}
}