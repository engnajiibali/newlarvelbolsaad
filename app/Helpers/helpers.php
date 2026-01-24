<?php
use App\Models\GeneralSetting;
use Carbon\Carbon;
use App\Lib\ClientInfo;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\UserRole;
use App\Models\system_setting;
use App\Models\User;
use App\Models\Department;
use App\Models\HoggankaCiidanka\Workplace;

/**********************************************
get Real IP address for the loged in user
**********************************************/
function getRealIP()
{
    $ip = $_SERVER["REMOTE_ADDR"];
//Deep detect ip
    if (filter_var(@$_SERVER['HTTP_FORWARDED'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_FORWARDED'];
    }
    if (filter_var(@$_SERVER['HTTP_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    if (filter_var(@$_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    if (filter_var(@$_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    if ($ip == '::1') {
        $ip = '197.220.84.97';
    }

    return $ip;
}
function getIpInfo()
{
$ipInfo = ClientInfo::ipInfo();
return $ipInfo;
}


function osBrowser()
{
$osBrowser = ClientInfo::osBrowser();
return $osBrowser;
}
/**********************************************
get Menu for the sidebar
**********************************************/
function getMenu()
{
    try {
        $menus = Menu::where('status', 'Active')->orderBy('menu_order')->get();
        return  $menus;
    } catch (Exception $ex) {
// Handle the exception
    }
}
/**********************************************
get subMenu for the sidebar
**********************************************/
function allowedSubmenus($userRole)
{
// Assuming 'role_menu' is a comma-separated string of submenu IDs (like "2,3,4,5,...")
$role = UserRole::find($userRole);  // Fetch the user role

// Convert the comma-separated string to an array and remove any empty values
$submenuString = $role->role_menu;  // Fetch the 'role_menu' field

// Split the string by commas and return an array of IDs
return array_filter(explode(',', $submenuString));
}

function getSiteName(){
            $settings= system_setting::findOrfail(1);
return $settings->name;

}

function getSiteLogo(){
            $settings= system_setting::findOrfail(1);
return $settings->Logo;

}
function getSiteFavicon(){
            $settings= system_setting::findOrfail(1);
return $settings->fava_icon;

}
function getAddress(){
            $settings= system_setting::findOrfail(1);
return $settings->Address;

}
function getTelephone(){
            $settings= system_setting::findOrfail(1);
return $settings->Telephone;

}
function getEmail(){
            $settings= system_setting::findOrfail(1);
return $settings->Email;

}
function showMobileNumber($number)
{
$length = strlen($number);
return substr_replace($number, '***', 4, $length - 6);
}

function showEmailAddress($email)
{
$endPosition = strpos($email, '@') - 1;
return substr_replace($email, '***', 1, $endPosition);
}

function getDepartmentNameByUserId() {
    $userId = session()->get('userId');

    if (!$userId) {
        return 'Unknown User (No ID in session)';
    }

    $user = User::find($userId);

    if (!$user) {
        return 'User Not Found';
    }

    $department = Department::find($user->department_id);

    return $department ? $department->name : 'Department Not Found';
}


function getDepartmentNameById($id){

            $departments= departments::where('id', '=', $id)->first();
return $departments->name;

}


/**********************************************
get crime_types
**********************************************/


