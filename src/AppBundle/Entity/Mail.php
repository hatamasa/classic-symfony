<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mail
 *
 * @ORM\Table(name="mail")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\MailRepository")
 */
class Mail
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="send_from", type="string", length=50)
     */
    private $sendFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="send_to", type="string", length=50)
     */
    private $sendTo;

    /**
     * @var string
     *
     * @ORM\Column(name="send_body", type="string", length=255)
     */
    private $sendBody;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Mail
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set sendFrom
     *
     * @param string $sendFrom
     *
     * @return Mail
     */
    public function setSendFrom($sendFrom)
    {
        $this->sendFrom = $sendFrom;

        return $this;
    }

    /**
     * Get sendFrom
     *
     * @return string
     */
    public function getSendFrom()
    {
        return $this->sendFrom;
    }

    /**
     * Set sendTo
     *
     * @param string $sendTo
     *
     * @return Mail
     */
    public function setSendTo($sendTo)
    {
        $this->sendTo = $sendTo;

        return $this;
    }

    /**
     * Get sendTo
     *
     * @return string
     */
    public function getSendTo()
    {
        return $this->sendTo;
    }

    /**
     * Set sendBody
     *
     * @param string $sendBody
     *
     * @return Mail
     */
    public function setSendBody($sendBody)
    {
        $this->sendBody = $sendBody;

        return $this;
    }

    /**
     * Get sendBody
     *
     * @return string
     */
    public function getSendBody()
    {
        return $this->sendBody;
    }

    public function setMail($message)
    {
    	$this->subject = $message->getSubject();

    	foreach($message->getFrom() as $key => $value){
    		$this->sendFrom .= $key . ',';
    	}

    	foreach($message->getTo() as $key => $value){
    		$this->sendTo .= $key . ',';
    	}

    	$this->sendBody = $message->getBody();
    }
}

