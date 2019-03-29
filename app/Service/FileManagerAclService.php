<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 3/28/2019
 * Time: 2:45 PM.
 */

namespace App\Service;


use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;

class FileManagerAclService implements ACLRepository
{

    /**
     * Get user ID
     *
     * @return mixed
     */
    public function getUserID()
    {
        return \Auth::id();
    }

    /**
     * Get ACL rules list for user
     *
     * You need to return an array, like this:
     *
     *  0 => [
     *      "disk" => "public"
     *      "path" => "music"
     *      "access" => 0
     *  ],
     *  1 => [
     *      "disk" => "public"
     *      "path" => "images"
     *      "access" => 1
     *  ]
     *
     * OR [] - if no results for selected user
     *
     * @return array
     */
    public function getRules(): array
    {
        //specify the file to be hide here
        return [
            ['disk' => 'public', 'path' => '.gitignore', 'access' => 0]
        ];
    }
}
