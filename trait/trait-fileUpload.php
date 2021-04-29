<?php declare(strict_types=1);
/* trait fileUpload
 * handles uploaading files
 * to the server
 */
trait fileUpload {

  private static string $dir = "../uploads/";

  /* function checkIfFileExists
   * Check uploads/ to see if the file
   * has already been uploaded
   * @param string filepath the path to the file
   * @return bool indicating success
   * @throws invalidPictureException if file is already
   * in uploads/
   */
  private function checkIfFileExists(string $filepath) : bool {
    if(file_exists($filepath)){
      throw new invalidPictureException("Picture already uploaded!");
      return false;
    } else
        return true;
  }

  /* function checkFileSize
   * Check the temporary file to see if 
   * it is under the file size limit (10MB)
   * @return bool indicating success
   * @throws invalidPictureException if 
   * the file is too large (or size 0)
   */
  private function checkFileSize() : bool {
    if ($_FILES["fileToUpload"]["size"] > 10000000) {
      throw new invalidPictureException("File is too large (10MB limit)");
      return false;
    }
    if ($_FILES["fileToUpload"]["size"] <= 0) {
      throw new invalidPictureException("File cannot be 0 or less in size");
      return false;
    }
    return true;
  }

  /* function limitFileType
   * limits file types to jpg, gif, png, jpeg
   * @returns bool indicating success
   * @throws invalidPictureException if not valid image type
   */
  private function limitFileType() : bool {
    $validTypes = array('image/gif', 'image/jpg', 'image/jpeg', 'image/png');
    foreach($validTypes as $v){
      if($_FILES['fileToUpload']['type'] == $v)
        return true;
      }
      throw new invalidPictureException("Picture must be jpg, gif, png, jpeg format");
      return false;
  }
  
  /* function storeProPic
   * runs the picture upload process and returns
   * the filepath to be stored in the database
   * @return the path to the picture location
   * @throws invalidPictureException if 
   * there was any error in uploading the file
   */ 
  public function storeProPic() : string{
    $filepath = self::$dir . basename($_FILES["fileToUpload"]["name"]);
    self::checkIfFileExists($filepath);
    self::limitFileType();
    self::checkFileSize();
    if ( !move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $filepath) || $_FILES["fileToUpload"]["error"] > 0 ) 
        throw new invalidPictureException("Failed to upload file");
    else
      return $filepath;
  }
}
?>