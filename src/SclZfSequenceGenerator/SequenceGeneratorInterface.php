<?php
namespace SclZfSequenceGenerator;

/**
 * Interface for a sequence generator.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
interface SequenceGeneratorInterface
{
    /**
     * Gets the next number in the sequence by name.
     *
     * @todo The transaction locks for reads and writes.
     *
     * @param string $name
     * @param int    $initialValue
     *
     * @return int
     */
    public function get($name, $initialValue = 1);
}
