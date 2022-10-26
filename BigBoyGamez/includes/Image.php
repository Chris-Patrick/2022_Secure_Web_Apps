<?php

/**
 * Image parameter class for the guitarShop application.
 * Contains methods for working with images in web page views.
 *
 * @author JAM
 * @version 2110307
 */
class Image {
	private $path; // file path and filename of the image relative to web tree root for this application
	private $imageInfo; // Array of image information as defined by the PHP getimagesize() function
	public function __construct($imageFilename) {
		$this->path = 'content/images/' . $imageFilename;
		if (file_exists ( $this->path )) {
			$this->imageInfo = getimagesize ( $this->path );
		} else {
			$this->path = null;
		}
	}

	/**
	 * Returns the height and width of an image in pixels that maintains aspect ratio if the largest dimension
	 * is set the specified maxiumum dimention.
	 *
	 * @param int $maxDim
	 *        	the maximum dimention in pixels for the scaled inmage
	 * @return int[] array containing the scaled image dimensions with the width in [0] and the height in [1]
	 */
	public function scaleDimensions($maxDim) {
		$outputDim = array ($maxDim, $maxDim);
		if ($this->path !== null) {
			if ($this->imageInfo [0] >= $this->imageInfo [1]) {
				$scaleRatio = $maxDim / $this->imageInfo [0];
				$outputDim [1] = (int) round ($this->imageInfo [1] * $scaleRatio, 0, PHP_ROUND_HALF_UP);
			} else {
				$scaleRatio = $maxDim / $this->imageInfo [1];
				$outputDim [0] = (int) round ($this->imageInfo [0] * $scaleRatio, 0, PHP_ROUND_HALF_UP);
			}
		} else {
			$outputDim === null;
		}
		return $outputDim;
	}

	/**
	 * Returns the height and width of an image in pixels that maintains aspect ratio if the width is set to the
	 * specified maximum width.
	 *
	 * @param int $maxWidth
	 *        	maximum width in pixels
	 * @return int[] array containing the scaled image dimensions with the width in [0] and the height in [1]
	 */
	public function scaleWidth($maxWidth) {
		$outputDim = array ($maxWidth, $maxWidth);
		if ($this->path !== null) {
			$scaleRatio = $maxWidth / $this->imageInfo [0];
			$outputDim [1] = (int) round ($this->imageInfo [1] * $scaleRatio, 0, PHP_ROUND_HALF_UP);
		} else {
			$outputDim = null;
		}
		return $outputDim;
	}

	/**
	 * Gets the path and filemane of a file relative to the web tree root for this application.
	 *
	 * @return string the path and filename of the file
	 */
	public function getPath() {
		return $this->path;
	}
}
