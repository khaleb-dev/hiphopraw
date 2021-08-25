<?php

require_once APPPATH . 'modules' . DS . 'utility.php';

class Controller_Photo extends Controller_Base {

    public function before()
    {
        parent::before();

        $login_exception = array("");

        parent::check_permission($login_exception);
    }

    public function action_index() {
        $view = View::forge('profile/my_photo');
        $profile = Model_Member::find($this->current_user_id);
        $image = Model_Image::get_member_photos($this->current_user_id);

        $view->page = 'Index';
        $view->profile = $profile;
        $view->my_photos = $image;
        $view->username = $profile->username;
        $view->thumbnail_2 = get_thumbnail_2($profile->avatar);
        return Response::forge($view);
    }

    public function action_manage() {
        $success = FALSE;
        $errors = array();

        $profile = Model_Member::find($this->current_user_id);
        if (isset($_POST['btnUploadPhoto'])) {
            $post = $_POST;
            unset($post['btnUploadPhoto']);

            if ($profile) {
                if ($_FILES['photo']['name']) {
                    $upload_path = DOCROOT . DS . 'uploads' . DS;
                    $member_directory = $upload_path . cleanUsername($profile->username) . DS;
                    createDirectory($member_directory);

                    $config = array(
                        'path' => $member_directory,
                        'randomize' => true,
                        'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                    );

                    Upload::process($config);
                    if (Upload::is_valid()) {
                        Upload::save();

                        $file = Upload::get_files(0);
                        $file_name = 'thumbnail_1_' . $file['saved_as'];
                        $post['member_id'] = $this->current_user_id;
                        $post['date_uploaded'] = date('Y-m-d');
                        $post['file_name'] = $file_name;
                        $objPhoto = new Model_Image($post);
                        $objPhoto->save();
                        
                        if(isset ($post['avatar'])) {
                            $profile->avatar = $file_name;
                            $profile->save();
                        }

                        //Resize image
                        $filepath = $file['saved_to'] . $file['saved_as'];

                        $width = 130;
                        $height = 105;
                        $thumbnail_1_filepath = $file['saved_to'] . 'thumbnail_1_' . $file['saved_as'];
                        $thumbnail_1 = Image::load($filepath)->crop_resize($width, $height)->save($thumbnail_1_filepath);

                        $width = 236;
                        $height = 195;
                        $thumbnail_2_filepath = $file['saved_to'] . 'thumbnail_2_' . $file['saved_as'];
                        $thumbnail_2 = Image::load($filepath)->crop_resize($width, $height)->save($thumbnail_2_filepath);

                        $success = TRUE;
                    } else {
                        
                    }
                } else {
                    
                }
            }
        }

        if (isset($_POST["btnRemovePhoto"]) && isset($_POST['image_items'])) {
            $image_items = $_POST['image_items'];
            
            $upload_path = DOCROOT . DS . 'uploads' . DS;
            $member_directory = $upload_path . cleanUsername($profile->username) . DS;
            
            if ($image_items) {
                foreach ($image_items as $item) {
                    $image = Model_Image::find($item);
                    if ($image) {
                        if ($image->file_name == $profile->avatar) {
                            $profile->avatar = "";
                            $profile->save();
                        }

                        //delete photo files
                        $base_file_name = get_photo_base_filename($image->file_name);
                        try {
                            $old_file_main = File::get($member_directory . $base_file_name);
                            $old_file_main->delete();
                        } catch (FileAccessException $e) {}

                        try {
                            $old_avatar = File::get($member_directory . $image->file_name);
                            $old_avatar->delete();
                        } catch (FileAccessException $e) {}

                        try {
                            $old_thumbnail_2 = File::get($member_directory . 'thumbnail_2_' . $base_file_name);
                            $old_thumbnail_2->delete();
                        } catch (FileAccessException $e) {}
                        
                        $image->delete();
                    }
                }
            }
        }

        $view = View::forge('profile/my_photo');
        $profile = Model_Member::find($this->current_user_id);
        $image = Model_Image::get_member_photos($this->current_user_id);

        $view->page = 'Manage Photos';
        $view->profile = $profile;
        $view->my_photos = $image;
        $view->username = $profile->username;
        $view->thumbnail_2 = get_thumbnail_2($profile->avatar);
        return Response::forge($view);
    }

}