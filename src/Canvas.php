<?php
namespace alf;

interface Canvas {
	const LINECAP_BUTT		= 0;
	const LINECAP_ROUND		= 1;
	const LINECAP_SQUARE	= 2;
	
	const LINEJOIN_MITER	= 0;
	const LINEJOIN_ROUND	= 1;
	const LINEJOIN_BEVEL	= 2;
	
	public function setFillColor($color);
	public function setStrokeColor($color);
	public function setFont($name, $size, $italic = false, $bold = false);
	
	public function setLineWidth($width);
	public function setLineCap($style);
	public function setLineJoin($style);
	public function setLineDash($segments, $offset = 0);
	
	public function save();
	public function restore();
	
	public function fillRect($x, $y, $width, $height);
	public function strokeRect($x, $y, $width, $height);
	public function fillText($text, $x, $y);
	public function strokeText($text, $x, $y);
	public function measureText($text);
	public function drawImage($image, $dx, $dy, $dWidth, $dHeight);
	
	public function moveTo($x, $y);
	public function lineTo($x, $y);
	public function closePath();
	public function fill();
	public function stroke();
	public function clip();
	
	public function rotate($angle);
	public function scale($x, $y);
	public function translate($x, $y);
	public function transform($hscale, $hskew, $vskew, $vscale, $dx, $dy);
}