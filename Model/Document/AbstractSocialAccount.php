<?php

namespace Youshido\SocialNetworksBundle\Model\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Field;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Id;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;
use Youshido\SocialNetworksBundle\Model\SocialableUserInterface;
use Youshido\SocialNetworksBundle\Service\SocialAccountInfo;

/**
 * @Document(collection="social_accounts")
 */
abstract class AbstractSocialAccount
{

    /**
     * @var string
     * @Id()
     */
    protected $id;

    /**
     * @Field(type="string")
     */
    protected $socialId;

    /**
     * @Field(type="string")
     */
    protected $provider;

    /**
     * @Field(type="string")
     */
    protected $firstName;

    /**
     * @Field(type="string")
     */
    protected $lastName;

    /**
     * @Field(type="string")
     */
    protected $email;

    /**
     * @Field(type="string")
     */
    protected $imageUrl;

    /** @var  SocialAccountInfo */
    protected $rawSocialInfo;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSocialId()
    {
        return $this->socialId;
    }

    /**
     * @param mixed $socialId
     * @return $this
     */
    public function setSocialId($socialId)
    {
        $this->socialId = $socialId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @param mixed $provider
     * @return $this
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param mixed $imageUrl
     * @return $this
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    /**
     * @return SocialAccountInfo
     */
    public function getRawSocialInfo()
    {
        return $this->rawSocialInfo;
    }

    /**
     * @param SocialAccountInfo $rawSocialInfo
     * @return AbstractSocialAccount
     */
    public function setRawSocialInfo($rawSocialInfo)
    {
        $this->rawSocialInfo = $rawSocialInfo;

        return $this;
    }

    /**
     * @return SocialableUserInterface
     */
    abstract public function getUser();

    /**
     * @param mixed $user
     * @return $this
     */
    abstract public function setUser($user);

}
