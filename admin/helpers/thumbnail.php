<?php
/**
* @package   JE Tour component
* @copyright Copyright (C) 2009-2010 Joomlaextensions.co.in All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/

define('THUMBNAIL_METHOD_SCALE_MAX', 0);

/**
 * Minimal scaling
 */
define('THUMBNAIL_METHOD_SCALE_MIN', 1);

/**
 * Cropping of fragment
 */
define('THUMBNAIL_METHOD_CROP',      2);

/**
 * Align constants
 */
define('THUMBNAIL_ALIGN_CENTER', 0);
define('THUMBNAIL_ALIGN_LEFT',   -1);
define('THUMBNAIL_ALIGN_RIGHT',  +1);
define('THUMBNAIL_ALIGN_TOP',    -1);
define('THUMBNAIL_ALIGN_BOTTOM', +1);

define('THUMBNAIL_MARK_TOP_LEFT', 1);
define('THUMBNAIL_MARK_TOP_RIGHT', 2);
define('THUMBNAIL_MARK_TOP_CENTER', 3);
define('THUMBNAIL_MARK_CENTER_CENTER', 4);
define('THUMBNAIL_MARK_BOTTOM_LEFT', 5);
define('THUMBNAIL_MARK_BOTTOM_RIGHT', 6);
define('THUMBNAIL_MARK_BOTTOM_CENTER', 7);
// }}}
// {{{

class Thumbnail
{

    // {{{

    /**
     * Create a GD image resource from given input.
     *
     * This method tried to detect what the input, if it is a file the
     * createImageFromFile will be called, otherwise createImageFromString().
     *
     * @param  mixed $input The input for creating an image resource. The value
     *                      may a string of filename, string of image data or
     *                      GD image resource.
     *
     * @return resource     An GD image resource on success or false
     * @access public
     * @static
     * @see    Thumbnail::imageCreateFromFile(), Thumbnail::imageCreateFromString()
     */
	 
	function CreatThumb($filetype,$tsrc,$dest,$n_width,$n_height){
		
	if ( $filetype == "jpg" || $filetype == "jpeg")
	$im=ImageCreateFromJPEG($dest); 	
	else if( $filetype == "gif")	
	$im=ImageCreateFromGIF($dest);
	else if($filetype=="png")
	$im=ImageCreateFromPNG($dest); 
			
	  $old_x=imageSX($im);
		
 		$old_y=imageSY($im);
 	
		if ($old_x > $old_y) {
			$n_width=$n_width;
			$n_height=$old_y*($n_height/$old_x);
		}
		if ($old_x < $old_y) {
			$n_width=$old_x*($n_width/$old_y);
			$n_height=$n_height;
		}
		if ($old_x == $old_y) {
			$n_width=$n_width;
			$n_height=$n_height;
		}

		
		if ( $filetype == "gif"){
		
			$im=ImageCreateFromGIF($dest);
			$width=ImageSx($im);              // Original picture width is stored
			$height=ImageSy($im);                  // Original picture height is stored
			$newimage=imagecreatetruecolor($n_width,$n_height);
			imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
		
			ImageGIF($newimage,$tsrc);
			chmod("$tsrc",0777);
					
		}
		if($filetype=="jpg" || $filetype == "jpeg"){
			$im=ImageCreateFromJPEG($dest); 
			$width=ImageSx($im);              // Original picture width is stored
			$height=ImageSy($im);             // Original picture height is stored
			$newimage=imagecreatetruecolor($n_width,$n_height);                 
			imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
			ImageJpeg($newimage,$tsrc);
			chmod("$tsrc",0777);
						
		}
		if($filetype=="png"){
			$im=ImageCreateFromPNG($dest); 
			$width=ImageSx($im);              // Original picture width is stored
			$height=ImageSy($im);             // Original picture height is stored
			$newimage=imagecreatetruecolor($n_width,$n_height);                 
			imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
			imagepng($newimage,$tsrc);
			chmod("$tsrc",0777);
										
		}
		
	} 
	 
	 
	 
    private static function imageCreate($input)
    {
        if ( is_file($input) ) {
            return Thumbnail::imageCreateFromFile($input);
        } else if ( is_string($input) ) {
            return Thumbnail::imageCreateFromString($input);
        } else {
            return $input;
        }
    }

    // }}}
    // {{{

    /**
     * Create a GD image resource from file (JPEG, PNG support).
     *
     * @param  string $filename The image filename.
     *
     * @return mixed            GD image resource on success, FALSE on failure.
     * @access public
     * @static
     */
    private static function imageCreateFromFile($filename)
    {
        if ( ! is_file($filename) || ! is_readable($filename) ) {
            trigger_error('Unable to open file "' . $filename . '"', E_USER_NOTICE);
            return false;
        }

        // determine image format
        list( , , $type) = getimagesize($filename);

        switch ($type) {
        case IMAGETYPE_JPEG:
            return imagecreatefromjpeg($filename);
            break;
        case IMAGETYPE_PNG:
            return imagecreatefrompng($filename);
            break;
		case IMAGETYPE_GIF:
            return imagecreatefromgif($filename);
            break;
        }
        trigger_error('Unsupport image type', E_USER_NOTICE);
        return false;
    }

    // }}}
    // {{{

    /**
     * Create a GD image resource from a string data.
     *
     * @param  string $string The string image data.
     *
     * @return mixed          GD image resource on success, FALSE on failure.
     * @access public
     * @static
     */
    private static function imageCreateFromString($string)
    {
        if ( ! is_string($string) || empty($string) ) {
            trigger_error('Invalid image value in string', E_USER_NOTICE);
            return false;
        }

        return imagecreatefromstring($string);
    }

    // }}}
    // {{{

    /**
     * Display rendered image (send it to browser or to file).
     * This method is a common implementation to render and output an image.
     * The method calls the render() method automatically and outputs the
     * image to the browser or to the file.
     *
     * @param  mixed   $input   Destination image, a filename or an image string data or a GD image resource
     * @param  array   $options Thumbnail options
     *         <pre>
     *         width   int    Width of thumbnail
     *         height  int    Height of thumbnail
     *         percent number Size of thumbnail per size of original image
     *         method  int    Method of thumbnail creating
     *         halign  int    Horizontal align
     *         valign  int    Vertical align
     *         </pre>
     *
     * @return boolean          TRUE on success or FALSE on failure.
     * @access public
     */
    public static function output($input, $output=null, $options=array())
    {
        // Load source file and render image
        $renderImage = Thumbnail::render($input, $options);
        if ( ! $renderImage ) {
            trigger_error('Error rendering image', E_USER_NOTICE);
            return false;
        }

        // Set output image type
        // By default PNG image
        $type = isset($options['type']) ? $options['type'] : IMAGETYPE_JPEG;

        // Before output to browsers send appropriate headers
        if ( empty($output) ) {
            $content_type = image_type_to_mime_type($type);
            if ( ! headers_sent() ) {
                header('Content-Type: ' . $content_type);
            } else {
                trigger_error('Headers have already been sent. Could not display image.', E_USER_NOTICE);
                return false;
            }
        }

        // Define outputing function
        switch ($type) {
        case IMAGETYPE_PNG:
            $result = empty($output) ? imagepng($renderImage) : imagepng($renderImage, $output);
            break;
        case IMAGETYPE_JPEG:
            $result = empty($output) ? imagejpeg($renderImage, null, 1) : imagejpeg($renderImage, $output, 100);
            break;
		case IMAGETYPE_GIF:
            $result = empty($output) ? imagegif($renderImage) : imagegif($renderImage, $output);
            break;
        default:
            user_error('Image type ' . $content_type . ' not supported by PHP', E_USER_NOTICE);
            return false;
        }

        // Output image (to browser or to file)
        if ( ! $result ) {
            trigger_error('Error output image', E_USER_NOTICE);
            return false;
        }

        // Free a memory from the target image
        imagedestroy($renderImage);

        return true;
    }

    // }}}
    // {{{ render()

    /**
     * Draw thumbnail result to resource.
     *
     * @param  mixed   $input   Destination image, a filename or an image string data or a GD image resource
     * @param  array   $options Thumbnail options
     *
     * @return boolean TRUE on success or FALSE on failure.
     * @access public
     * @see    Thumbnail::output()
     */
    private static function render($input, $options=array())
    {
        // Create the source image
        $sourceImage = Thumbnail::imageCreate($input);
        if ( ! is_resource($sourceImage) ) {
            trigger_error('Invalid image resource', E_USER_NOTICE);
            return false;
        }
        $sourceWidth  = imagesx($sourceImage);
        $sourceHeight = imagesy($sourceImage);

        // Set default options
        static $defOptions = array(
            'width'   => 150,
            'height'  => 150,
            'method'  => THUMBNAIL_METHOD_SCALE_MAX,
            'percent' => 0,
            'halign'  => THUMBNAIL_ALIGN_CENTER,
            'valign'  => THUMBNAIL_ALIGN_CENTER,
			'corner'  => 0,
			'corcolor'  => 'FFFFFF',
			'cortransparent' => 0,
			'mark'  => 0,
			'mark-image'  => null
        );
        foreach ($defOptions as $k => $v) {
            if ( ! isset($options[$k]) ) {
                $options[$k] = $v;
            }
        }

        // Estimate a rectangular portion of the source image and a size of the target image
        if ( $options['method'] == THUMBNAIL_METHOD_CROP ) {
            if ( $options['percent'] ) {
                $W = floor($options['percent'] * $sourceWidth);
                $H = floor($options['percent'] * $sourceHeight);
            } else {
                $W = $options['width'];
                $H = $options['height'];
            }

            $width  = $W;
            $height = $H;

            $Y = Thumbnail::_coord($options['valign'], $sourceHeight, $H);
            $X = Thumbnail::_coord($options['halign'], $sourceWidth,  $W);
        } else {
            $X = 0;
            $Y = 0;

            $W = $sourceWidth;
            $H = $sourceHeight;

            if ( $options['percent'] ) {
                $width  = floor($options['percent'] * $W);
                $height = floor($options['percent'] * $H);
            } else {
                $width  = $options['width'];
                $height = $options['height'];

                if ( $options['method'] == THUMBNAIL_METHOD_SCALE_MIN ) {
                    $Ww = $W / $width;
                    $Hh = $H / $height;
                    if ( $Ww > $Hh ) {
                        $W = floor($width * $Hh);
                        $X = Thumbnail::_coord($options['halign'], $sourceWidth,  $W);
                    } else {
                        $H = floor($height * $Ww);
                        $Y = Thumbnail::_coord($options['valign'], $sourceHeight, $H);
                    }
                } else {
                    if ( $H > $W ) {
                        $width  = floor($height / $H * $W);
                    } else {
                        $height = floor($width / $W * $H);
                    }
                }
            }
        }

        // Create the target image
        if ( function_exists('imagecreatetruecolor') ) {
            $targetImage = imagecreatetruecolor($width, $height);
			imageAlphaBlending($targetImage, false);
			imageSaveAlpha($targetImage, true);
			$transparency = imagecolorallocatealpha($targetImage, 0, 0, 0, 127);
			imagefill($targetImage, 0, 0, $transparency);
        } else {
            $targetImage = imagecreate($width, $height);
        }
        if ( ! is_resource($targetImage) ) {
            trigger_error('Cannot initialize new GD image stream', E_USER_NOTICE);
            return false;
        }

        // Copy the source image to the target image
        if ( $options['method'] == THUMBNAIL_METHOD_CROP ) {
            $result = imagecopy($targetImage, $sourceImage, 0, 0, $X, $Y, $W, $H);
        } elseif ( function_exists('imagecopyresampled') ) {
            $result = imagecopyresampled($targetImage, $sourceImage, 0, 0, $X, $Y, $width, $height, $W, $H);
        } else {
            $result = imagecopyresized($targetImage, $sourceImage, 0, 0, $X, $Y, $width, $height, $W, $H);
        }
        if ( ! $result ) {
            trigger_error('Cannot resize image', E_USER_NOTICE);
            return false;
        }
		
		
		
		
		
		if ($options['corner'] > 0) {
			/* corner background-color */
			$radius = $options['corner'];
			$colour = $options['corcolor'];
			$source_width = $width;
			$source_height = $height;
			$corner_image = imagecreatetruecolor($radius,$radius);
			$clear_colour = imagecolorallocate($corner_image,0,0,0);
			$solid_colour = imagecolorallocate( $corner_image, hexdec( substr( $colour, 0, 2 ) ), hexdec( substr( $colour, 2, 2 ) ), hexdec( substr( $colour, 4, 2 ) ) ); 
			imagecolortransparent($corner_image,$clear_colour);
			imagefill( $corner_image, 0, 0, $solid_colour ); 
			imagefilledellipse($corner_image, $radius, $radius, $radius * 2, $radius * 2, $clear_colour ); 			
			imagecopymerge($targetImage, $corner_image, 0, 0, 0, 0, $radius, $radius, 100 ); 
			$corner_image = imagerotate( $corner_image, 90, 0 );
			imagecopymerge($targetImage, $corner_image, 0, $source_height - $radius, 0, 0, $radius, $radius, 100 ); 
			$corner_image = imagerotate( $corner_image, 90, 0 );
			imagecopymerge($targetImage, $corner_image, $source_width - $radius, $source_height - $radius, 0, 0, $radius, $radius, 100);
			$corner_image = imagerotate( $corner_image, 90, 0 );
			imagecopymerge($targetImage,$corner_image,$source_width - $radius, 0, 0, 0, $radius, $radius, 100);
			
		}
		if ($options['cortransparent'] > 0) {
			/* corner (transparent) */
			$bwidth	= $options['cortransparent'];
			$width_orig = $width;
			$height_orig = $height;
			$img = $targetImage;
			$mask = imagecreatetruecolor($width_orig, $height_orig);
			$white = imagecolorallocate($mask, 255, 255, 255);
			imagefill($mask, 0, 0, $white);
			$cornerImg = imagecreatetruecolor($bwidth, $bwidth);
			$transp = imagecolorallocate($cornerImg, 0, 0, 0);
			imagefill($cornerImg, 0, 0, $transp);
			$bgc = imagecolorallocate($cornerImg, 255, 255, 255);
			imagefilledellipse($cornerImg, $bwidth, $bwidth, $bwidth*2, $bwidth*2, $bgc);
			imagecolortransparent($cornerImg, $bgc);
			imagecopymerge($mask, $cornerImg, 0, 0, 0, 0, $bwidth, $bwidth, 100);
			$cornerImg = imagerotate($cornerImg, 270,0);
			imagecopymerge($mask, $cornerImg, $width_orig-$bwidth, 0, 0, 0, $bwidth, $bwidth, 100);
			$cornerImg = imagerotate($cornerImg, 270,0);
			imagecopymerge($mask, $cornerImg, $width_orig-$bwidth, $height_orig-$bwidth, 0, 0, $bwidth, $bwidth, 100);
			$cornerImg = imagerotate($cornerImg, 270,0);
			imagecopymerge($mask, $cornerImg, 0, $height_orig-$bwidth, 0, 0, $bwidth, $bwidth, 100);

			$newImage = imagecreatetruecolor( $width_orig, $height_orig );
			imagesavealpha( $newImage, true );
			$allocatedAlpha=imagecolorallocatealpha( $newImage, 0, 0, 0, 127 );
			imagefill( $newImage, 0, 0, $allocatedAlpha );

			for( $x = 0; $x < $width_orig; $x++ ) {
				for( $y = 0; $y < $height_orig; $y++ ) {
					$alpha = imagecolorsforindex( $mask, imagecolorat( $mask, $x, $y ) );
					$alpha = 127 - floor( $alpha['red'] / 2 );
					$colour = imagecolorsforindex( $img, imagecolorat( $img, $x, $y ) );
					imagesetpixel( $newImage, $x, $y, imagecolorallocatealpha( $newImage, $colour[ 'red' ], $colour[ 'green' ], $colour[ 'blue' ], $alpha ) );
				}
			}
			$targetImage = $newImage;
			
		}
		if ($options['mark'] > 0 AND $options['mark-image']) {
			imagealphablending($targetImage, true); 
			
			if(!file_exists($options['mark-image'])) die("Cannot watermark image");
			
			$maskwatermark = imagecreatefrompng($options['mark-image']);
			$owidth = imagesx($maskwatermark); 
			$oheight = imagesy($maskwatermark);
			$m_width = 0;
			$m_height = 0;
			switch ($options['mark']) {
				case 1: // top left
					break;
				case 2: // top right
					$m_width = ($width-$owidth);
					break;
				case 3: // top center
					$m_width = ($width-$owidth)/2;
					break;
				case 4: // center center
					$m_width = ($width-$owidth)/2;
					$m_height = ($height-$oheight)/2;
					break;
				case 5: // bottom left
					$m_height = ($height-$oheight);
					break;
				case 6: // bottom right
					$m_width = ($width-$owidth);
					$m_height = ($height-$oheight);
					break;
				case 7: // bottom center
					$m_width = ($width-$owidth)/2;
					$m_height = ($height-$oheight);
					break;
				default:
					user_error('Image type ' . $content_type . ' not supported by PHP', E_USER_NOTICE);
					return false;
			}
			imagecopy($targetImage, $maskwatermark, $m_width, $m_height, 0, 0, $owidth, $oheight); 
  
		}
		
        imagedestroy($sourceImage);
        return $targetImage;
    }

    // }}}
    // {{{ _coord()

    private static function _coord($align, $param, $src)
    {
        if ( $align < THUMBNAIL_ALIGN_CENTER ) {
            $result = 0;
        } elseif ( $align > THUMBNAIL_ALIGN_CENTER ) {
            $result = $param - $src;
        } else {
            $result = ($param - $src) >> 1;
        }
        return $result;
    }


	
    // }}}

}


	
