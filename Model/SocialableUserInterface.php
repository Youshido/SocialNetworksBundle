<?php

namespace Youshido\SocialNetworksBundle\Model;

/**
 * This file is a part of MyShowdown - BackendApp project.
 *
 * @author Alexandr Viniychuk <a@viniychuk.com>
 * created: 2/25/17 12:14 AM
 */
interface SocialableUserInterface
{

    public function setFirstName($name);

    public function setLastName($name);

    public function setEmail($email);

}