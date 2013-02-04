<?php
/**
 * Constains the definition of the SequenceGenerator class.
 *
 * @author Tom Oram
 */

namespace SclZfSequenceGenerator;

use Doctrine\ORM\EntityManager;
use SclZfSequenceGenerator\Entity\SequenceNumber;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Returns sequential numbers. 
 *
 * @author Tom Oram
 */
class DoctrineSequenceGenerator implements
    SequenceGeneratorInterface, 
    ServiceLocatorAwareInterface
{
    /**
     * The entity manager used to access the database.
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     * The service locator 
     *
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * 
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Return the Doctrine EntityManager.
     *
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        if (null === $this->entityManager) {
            $sl = $this->getServiceLocator();
            $this->entityManager = $sl->get('doctrine.entitymanager.orm_default');
        }
        return $this->entityManager;
    }

    /**
     * Create a new sequence number entity.
     *
     * @param string  $name
     * @param integer $initialValue
     *
     * @return SequenceNumber
     */
    protected function createSequence($name, $initialValue)
    {
        $sequence = $this->getServiceLocator()->get('SclZfSequenceGenerator\Entity\SequenceNumber');
        $sequence->setName($name)
            ->setValue($initialValue);

        return $sequence;
    }

    /**
     * Fetches a sequence number from the database.
     *
     * @param string $name
     *
     * @return NULL|SequenceNumber
     *
     * @throws \Exception
     */
    protected function findSequence($name)
    {
        $dql = 'SELECT sn '
             . 'FROM SclZfSequenceGenerator\Entity\SequenceNumber sn '
             . 'WHERE sn.name = ?1';

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter(1, $name);

        $result = $query->getResult();

        if (!$result) {
            return null;
        }

        if (count($result) > 1) {
            throw new \Exception("Multiple sequence numbers found for name {$name}.");
        }

        return $result[0];
    }

    /**
     * {@inheritDoc}
     */
    public function get($name, $initialValue = 1)
    {
        $entityManager = $this->getEntityManager();

        $entityManager->getConnection()->beginTransaction();

        try {
            $sequence = $this->findSequence($name);

            if (null === $sequence) {
                $sequence = $this->createSequence($name, $initialValue);
            }

            $value = $sequence->getNext();

            $entityManager->persist($sequence);
            $entityManager->flush();
            $entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            $entityManager->getConnection()->rollback();
            $entityManager->close();
            throw $e;
        }

        return $value;
    }
}
