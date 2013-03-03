<?php
/**
 * Contains the definition of the SequencedNumber class.
 *
 * @author Tom Oram
 */

namespace SclZfSequenceGenerator\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a number in the sequence table.
 *
 * @ORM\Entity
 * @ORM\Table(name="sequence_generator")
 * @author Tom Oram
 */
class SequenceNumber
{
    /**
     * This id of the entity.
     *
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * A textual name to refer to the sequences by.
     *
     * @var string
     * @ORM\Column(type="string", unique=true)
     */
    protected $name;

    /**
     * The current number in the sequence.
     *
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $value;

    /**
     * Set id
     *
     * @param integer $id
     * @return SequenceNumber
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

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
     * Set name
     *
     * @param string $name
     * @return SequenceNumber
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return SequenceNumber
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Return the next number in the sequence and update the object.
     *
     * @return integer;
     */
    public function getNext()
    {
        return ++$this->value;
    }
}
