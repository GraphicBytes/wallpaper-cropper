<?php
/**
 * Create a URL slug from a string
 *
 * @param string $str String to create slug from (str)
 * @param mixed $limit Limit the number of characters returned (optional)
 * @return string
 * @author Steve Grunwell
 */
function create_slug($str, $limit=64){

  /*
    Hash of common accented characters and their best URL-friendly equivalents
    Credit to sales@mk2solutions.com on http://php.net/manual/en/function.strtr.php
  */
  $replacements = array(
    'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
    'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
    'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
    'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
    'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
    'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
    'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f', '&'=>'and'
  );

  $str = strtr($str, $replacements); // Replace accented/special characters
  $str = preg_replace('/\s+/', '-', trim($str)); // Trim and remove spaces
  $str = str_replace('_', '-', $str); // Underscores to dashes
  $str = preg_replace('/[^a-z0-9-]/i', '', strtolower($str)); // Only alpha-numeric and dashes are permitted
  $str = preg_replace('/-+/', '-', $str); // Prevent 2+ dashes from appearing together

  // Limit the number of characters
  if( intval($limit) > 0 ){
    $str = substr($str, 0, intval($limit));
  }

  // Don't end in a dash
  if( substr($str, -1, 1) === '-' ){
    $str = substr($str, 0, -1);
  }

  return $str;
}
?>
