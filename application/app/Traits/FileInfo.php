<?php

namespace App\Traits;

trait FileInfo
{

    /*
    |--------------------------------------------------------------------------
    | File Information
    |--------------------------------------------------------------------------
    |
    | This trait basically contain the path of files and size of images.
    | All information are stored as an array. Developer will be able to access
    | this info as method and property using FileManager class.
    |
    */

    public function fileInfo()
    {

        $data['depositVerify'] = [
            'path'      => 'assets/images/verify/deposit'
        ];
        $data['verify'] = [
            'path'      => 'assets/verify'
        ];
        $data['default'] = [
            'path'      => 'assets/images/general/default.png',
        ];
        $data['ticket'] = [
            'path'      => 'assets/support',
        ];
        $data['logoIcon'] = [
            'path'      => 'assets/images/general',
        ];
        $data['favicon'] = [
            'size'      => '128x128',
        ];
        $data['extensions'] = [
            'path'      => 'assets/images/plugins',
            'size'      => '36x36',
        ];
        $data['seo'] = [
            'path'      => 'assets/images/seo',
            'size'      => '1180x600',
        ];
        $data['product'] = [
            'path'      => 'assets/images/products',
            'size'      => '856x491',
        ];
        $data['product_poster'] = [
            'path'      => 'assets/images/products',
            'size'      => '294x397',
        ];
        $data['topup'] = [
            'path'      => 'assets/images/topups',
            'size'      => '430x377',
        ];
        $data['topup_instruct'] = [
            'path'      => 'assets/images/topups/instructs',
            'size'      => '855x335',
        ];
        $data['userProfile'] = [
            'path'      => 'assets/images/user/profile',
            'size'      => '350x300',
        ];
        $data['adminProfile'] = [
            'path'      => 'assets/admin/images/profile',
            'size'      => '400x400',
        ];
        $data['frontend'] = [
            'path'      => 'assets/images/frontend',
        ];

        $data['adImage'] = [
            'path'      => 'assets/images/frontend/adImage',
        ];
        return $data;
    }
}
