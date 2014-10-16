<?php 


/**
 * @file Library to provide various functions for listing files
 *
 * rev. 11/14/2011 ok
 * rev. 1/12/2012 ok: added documentation
 */

 
/**
 * Function to obtain file extension.
 */
function file_extension($filename) {
  $temp = explode(".", $filename); // temporary variable is needed,
                                   // otherwise the program returns
                                   // "Strict Standards: Only variables should be passed by reference" warning
  return end($temp);
}


/**
 * Function ListFiles
 * 
 *   Creates list of files in a given directory and all its subdirectories.
 *
 * @param string $dir
 * @param string $extension
 *
 * @return ... returns array with file names
 *

====== Additional resources on this function ======

(1) PHP scandir function

(2) http://www.webmaster-talk.com/php-forum/41811-list-files-in-directory-sub-directories.html

>>> The site provides the following function (below), which was slightly modified
    to extract only files with specified extension

function ListFiles($dir) {

    if($dh = opendir($dir)) {

        $files = Array();
        $inner_files = Array();

        while($file = readdir($dh)) {
            if($file != "." && $file != ".." && $file[0] != '.') {
                if(is_dir($dir . "/" . $file)) {
                    $inner_files = ListFiles($dir . "/" . $file);
                    if(is_array($inner_files)) $files = array_merge($files, $inner_files); 
                } else {
                    array_push($files, $dir . "/" . $file);
                }
            }
        }

        closedir($dh);
        return $files;
    }
}


====== Usage example: looping through all XML files ======

foreach (list_files('/home', 'xml') as $key=>$file){
    echo $file ."<br />";
}
 *
 *
 */
function list_files($dir, $extension) {

   if($dh = opendir($dir)) {

      $files = Array();
      $inner_files = Array();

      while($file = readdir($dh)) {
         if($file != "." && $file != ".." && $file[0] != '.') {
            if(is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
               $inner_files = list_files($dir . DIRECTORY_SEPARATOR . $file, $extension);
               if(is_array($inner_files)) $files = array_merge($files, $inner_files); 
            } else {
					if (file_extension($file) == $extension) { //add files with the specified extension
                  array_push($files, $dir . DIRECTORY_SEPARATOR . $file);
               }
            }
         }
      }

      closedir($dh);
      return $files;
   }
   
}

/**
 *
 * Function list_files_by_filename
 * 
 *   Creates list of files with a given filename in a given directory and all its subdirectories.
 *
 * @param string $dir ... directory to parse
 * @param string $filename ... names of files to be included
 *
 * @return ... returns array with file names (absolute paths)
 *
 */
function list_files_by_filename($dir, $filename) {

   if($dh = opendir($dir)) {

      $files = Array();
      $inner_files = Array();

      while($file = readdir($dh)) {
         if($file != "." && $file != ".." && $file[0] != '.') {
            if(is_dir($dir . "/" . $file)) {
               $inner_files = list_files_by_filename($dir . "/" . $file, $filename);
               if(is_array($inner_files)) $files = array_merge($files, $inner_files); 
            } else {
					if ($file == $filename) {
                  array_push($files, $dir . "/" . $file);
               }
            }
         }
      }

      closedir($dh);
      return $files;
   }
   
}

?>