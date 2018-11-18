<?php

require_once('./models/User.php');
require_once('./controllers/Auth.php');

class UserController extends Controller
{
  /**
   * Constructs UserController.
   *
   */
  public function __construct()
  {
    if (!Auth::check()){
      return $this->redirect('/index.php/login');
    }
  }

  /**
   * Profile handler.
   *
   * @return view profile.php.
   */
  public function profile(){
    $user = Auth::user();

    return $this->view('profile.php', [
      'user' => $user,
    ]);
  }

  /**
   * Edit handler.
   *
   * @return view edit.php.
   */
  public function edit(){
    $user = Auth::user();

    return $this->view('edit_profile.php', [
      'user' => $user,
    ]);
  }

  /**
   * Update profile handler.
   * @param array request validated data from form in edit.profile.php.
   */
  public function update($request){
    // Upload image.
    $uploaded = true;
    if ($_FILES['image']['size'] > 0) {
      $baseDir = $_SERVER['DOCUMENT_ROOT'];
      $targetDir = '/public/images/profiles/';
      $tempFile = $_FILES['image']['tmp_name'];
      $ext = pathinfo($_FILES['image']['name'])['extension'];
      $fileName = $targetDir . Auth::user()['username'] . '.' . $ext;
      if (file_exists($baseDir . Auth::user()['image_path'])) {
        $deleted = unlink($baseDir . $fileName);
      }
      $uploaded = move_uploaded_file($tempFile, $baseDir . $fileName);
      if ($uploaded) {
        $request['image_path'] = $fileName;
      }
    }

    $user = new User();
    if ($user->update(Auth::user()['id'], $request) && $uploaded) {
      return $this->redirect('/index.php/profile', [
        'message' => "Your profile was successfully updated!",
      ]);
    }

    return $this->redirect('/index.php/profile/edit', [
      'message' => "Failed to edit your profile",
    ]);
  }
}
