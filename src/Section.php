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
		
		if($width!==false){
			if($box == self::BORDER_BOX){
				$this->width	= $width;
				if(isset($this->style['padding-left'])) $width-= $this->style['padding-left'];
				if(isset($this->style['padding-right'])) $width-= $this->style['padding-right'];
				if(isset($this->style['border-left-width'])) $width-= $this->style['border-left-width'];
				if(isset($this->style['border-right-width'])) $width-= $this->style['border-right-width'];
				$this->contents = new Body($width);
			}elseif($box == self::CONTENT_BOX){
				$this->contents = new Body($width);
				if(isset($this->style['padding-left'])) $width+= $this->style['padding-left'];
				if(isset($this->style['padding-right'])) $width+= $this->style['padding-right'];
				if(isset($this->style['border-left-width'])) $width+= $this->style['border-left-width'];
				if(isset($this->style['border-right-width'])) $width+= $this->style['border-right-width'];
				$this->width	= $width;
			}else{
				throw new \Exception('Invalid box model');
			}
		}else{
			$this->contents = new Body(false);
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
		if($this->width === false) throw new \Exception('Width not set');
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
		if(isset($this->style['border-top-width'])) $height+= $this->style['border-top-width'];
		if(isset($this->style['border-bottom-width'])) $height+= $this->style['border-bottom-width'];
		
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
		if(isset($this->style['border-top-width'])) $height+= $this->style['border-top-width'];
		if(isset($this->style['border-bottom-width'])) $height+= $this->style['border-bottom-width'];
		
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
	 * @see \alf\Packable::getMinimalWidth()
	 */
	public function getMinimalWidth(){
		$width = $this->contents->getMinimalHeight();
		
		if(isset($this->style['padding-left'])) $width+= $this->style['padding-left'];
		if(isset($this->style['padding-right'])) $width+= $this->style['padding-right'];
		if(isset($this->style['border-left-width'])) $width+= $this->style['border-left-width'];
		if(isset($this->style['border-right-width'])) $width+= $this->style['border-right-width'];
		
		return $width;
	}
	
	/**
	 * 
	 * {@inheritDoc}
	 * @see \alf\Packable::getCalulatedWidth()
	 */
	public function getCalulatedWidth(){
		$width = $this->contents->getCalulatedWidth();
		
		if(isset($this->style['padding-left'])) $width+= $this->style['padding-left'];
		if(isset($this->style['padding-right'])) $width+= $this->style['padding-right'];
		if(isset($this->style['border-left-width'])) $width+= $this->style['border-left-width'];
		if(isset($this->style['border-right-width'])) $width+= $this->style['border-right-width'];
		
		return $width;
	}
	
	/**
	 * TODO aply correct bounding model
	 * {@inheritDoc}
	 * @see \alf\Packable::pack()
	 */
	public function pack($width){
		$this->width = $width;
		
		if(isset($this->style['padding-left'])) $width-= $this->style['padding-left'];
		if(isset($this->style['padding-right'])) $width-= $this->style['padding-right'];
		if(isset($this->style['border-left-width'])) $width-= $this->style['border-left-width'];
		if(isset($this->style['border-right-width'])) $width-= $this->style['border-right-width'];
		
		
		if($this->contents->pack($width)!==false) throw new \Exception('Unexpected return value');
		return false;
	}
	
	/**
	 *
	 * {@inheritDoc}
	 * @see \alf\Renderable::render()
	 */
	public function render($canvas){
		$this->renderBackground(new TranslatedCanvas($canvas, $this->lineLeft, $this->lineTop));
		$this->renderContents(new TranslatedCanvas($canvas, $this->lineLeft, $this->lineTop));
		$this->renderBorder(new TranslatedCanvas($canvas, $this->lineLeft, $this->lineTop));
	}
	
	/**
	 * 
	 * @param \alf\Canvas $canvas
	 * @return boolean
	 */
	private function renderBackground($canvas){
		if(!isset($this->style['background-color'])) return false;
		
		$canvas->setFillColor($this->style['background-color']);
		$canvas->fillRect(0, 0, $this->width, $this->getHeight());
		
		return true;
	}
	
	/**
	 * 
	 * @param \alf\Canvas $canvas
	 * @return boolean
	 */
	private function renderContents($canvas){
		$this->getBorderlessBox($left, $top, $width, $height);
		
		if(isset($this->style['padding-left'])) $left+= $this->style['padding-left']; 
		if(isset($this->style['padding-top'])) $top+= $this->style['padding-top']; 
		$this->contents->render(new TranslatedCanvas($canvas, $left, $top));
		
		return true;
	}
	
	/**
	 * 
	 * @param \alf\Canvas $canvas
	 * @return boolean
	 */
	private function renderBorder($canvas){
		$this->getBorderlessBox($left, $top, $width, $height);
		$canvas->setFillColor('#00ff00');
		
		if(isset($this->style['border-top-width'])){
			$canvas->save();
			$canvas->moveTo(0, 0);
			$canvas->lineTo($this->getWidth(), 0);
			$canvas->lineTo($left + $width, $top);
			$canvas->lineTo($left, $top);
			$canvas->clip();
			
			$halveWidth = $this->style['border-top-width'] / 2;
			$canvas->moveTo($halveWidth, $halveWidth);
			$canvas->LineTo($this->getWidth() - $halveWidth, $halveWidth);
			$this->setBorderStyle($canvas, $this->style['border-top-style'], $this->style['border-top-width'], $this->style['border-top-color']);
			
			$canvas->restore();
		}
		
		if(isset($this->style['border-bottom-width'])){
			$canvas->save();
			$canvas->moveTo($left, $top + $height);
			$canvas->lineTo($left + $width, $top + $height);
			$canvas->lineTo($this->getWidth(), $this->getHeight());
			$canvas->lineTo(0, $this->getHeight());
			$canvas->clip();
			
			$halveWidth = $this->style['border-bottom-width'] / 2;
			$canvas->moveTo($halveWidth, $this->getHeight() - $halveWidth);
			$canvas->LineTo($this->getWidth() - $halveWidth, $this->getHeight() - $halveWidth);
			$this->setBorderStyle($canvas, $this->style['border-bottom-style'], $this->style['border-bottom-width'], $this->style['border-bottom-color']);
			
			$canvas->restore();
		}
		
		if(isset($this->style['border-left-width'])){
			$canvas->save();
			$canvas->moveTo(0, 0);
			$canvas->lineTo($left, $top);
			$canvas->lineTo($left, $top + $height);
			$canvas->lineTo(0, $this->getHeight());
			$canvas->clip();
			
			$halveWidth = $this->style['border-left-width'] / 2;
			$canvas->moveTo($halveWidth, $halveWidth);
			$canvas->LineTo($halveWidth, $this->getHeight() - $halveWidth);
			$this->setBorderStyle($canvas, $this->style['border-left-style'], $this->style['border-left-width'], $this->style['border-left-color']);
			
			$canvas->restore();
		}
		
		if(isset($this->style['border-right-width'])){
			$canvas->save();
			$canvas->moveTo($this->getWidth(), 0);
			$canvas->lineTo($this->getWidth(), $this->getHeight());
			$canvas->lineTo($left + $width, $top + $height);
			$canvas->lineTo($left + $width, $top);
			$canvas->clip();
			
			$halveWidth = $this->style['border-right-width'] / 2;
			$canvas->moveTo($this->getWidth() - $halveWidth, $halveWidth);
			$canvas->LineTo($this->getWidth() - $halveWidth, $this->getHeight() - $halveWidth);
			$this->setBorderStyle($canvas, $this->style['border-right-style'], $this->style['border-right-width'], $this->style['border-right-color']);
			
			$canvas->restore();
		}
	}
	
	/**
	 * 
	 * @param \alf\Canvas $canvas
	 * @param string $style
	 * @param number $width
	 * @param string $color
	 */
	private function setBorderStyle($canvas, $style, $width, $color){
		switch($style){
			case 'dashed':
				$canvas->setLineCap(Canvas::LINECAP_SQUARE);
				$canvas->setLineDash([$width, 2 * $width]);
			break;
			case 'solid':
				$canvas->setLineCap(Canvas::LINECAP_SQUARE);
				$canvas->setLineDash([0, 0]);
			break;
			case 'dotted':
				$canvas->setLineCap(Canvas::LINECAP_ROUND);
				$canvas->setLineDash([0, 2 * $width]);
			break;
			default: throw new \Exception('Unsupported line style');
		}
		$canvas->setLineWidth($width);
		$canvas->setStrokeColor($color ?? '#000000');
		$canvas->stroke();
	}
	
	/**
	 * 
	 * 
	 * @param number $left
	 * @param number $top
	 * @param number $width
	 * @param number $height
	 */
	private function getBorderlessBox(&$left, &$top, &$width, &$height){
		$left	= 0; 
		$top	= 0; 
		if(isset($this->style['border-left-width'])) $left+= $this->style['border-left-width']; 
		if(isset($this->style['border-top-width'])) $top+= $this->style['border-top-width'];
		$width	= $this->width - $left; 
		$height	= $this->getHeight() - $top; 
		if(isset($this->style['border-right-width'])) $width-= $this->style['border-right-width']; 
		if(isset($this->style['border-bottom-width'])) $height-= $this->style['border-bottom-width']; 
	}
}