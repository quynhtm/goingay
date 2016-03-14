<?php
/**
 * 
 ** @author ManhQuynh-VCC
 *
 */
class AdminAdvertise extends Module
{
    function AdminAdvertise($row)
    {
        Module::Module($row);
        $cmd = Url::get('cmd');
        if (User::is_root()) {
            switch ($cmd) {
                case 'delete':
                    $id = (int)Url::get('id', 0);
                    if ($id) {
                        SvImg::deleteImage(DB::get_one('SELECT `image` FROM ' . TABLE_ADVERTISE . ' WHERE id =' . $id), CGlobal::$adv_image_sizes, $id, SvImg::FOLDER_AVATAR, OPT_DELETE_IMAGE);
                        DB::delete_id(TABLE_ADVERTISE, $id);
                    }
                    Url::redirect_current();
                    break;
                case 'status':
                    $id = (int)Url::get('id', 0);
                    $status = (int)Url::get('status', 0);
                    if ($id) {
                        DB::update(TABLE_ADVERTISE, array('status' => ($status == 1) ? 0 : 1), 'id=' . $id);
                    }
                    Url::redirect_current();
                    break;
                case 'edit':
                case 'add':
                    require_once 'forms/EditAdvertise.php';
                    $this->add_form(new EditAdvertiseForm());
                    break;
                default:
                    require_once 'forms/ListAdvertise.php';
                    $this->add_form(new ListAdvertiseForm());
                    break;
            }
        } else {
            Url::redirect('admin');
        }
    }
}

?>