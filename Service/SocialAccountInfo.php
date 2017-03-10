<?php
/**
 * This file is a part of MyShowdown - BackendApp project.
 *
 * @author Alexandr Viniychuk <a@viniychuk.com>
 * created: 2/24/17 6:18 PM
 */

namespace Youshido\SocialNetworksBundle\Service;


class SocialAccountInfo
{

    /** @var  string */
    private $id;
    /** @var  string */
    private $firstName;

    /** @var  string */
    private $lastName;

    /** @var  string */
    private $email;

    /** @var  string */
    private $accessToken;

    /** @var  string */
    private $imageUrl;

    /**
     * UserInfoDTO constructor.
     *
     * @param string $id
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $imageUrl
     * @param string $accessToken
     */
    public function __construct($id, $firstName, $lastName = null, $email, $imageUrl = null, $accessToken)
    {
        $this->id          = $id;
        $this->firstName   = $firstName;
        $this->lastName    = $lastName;
        $this->email       = $email;
        $this->imageUrl    = $imageUrl;
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }
}