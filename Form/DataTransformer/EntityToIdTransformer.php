<?php

namespace Sunsetlabs\EcommerceResourceBundle\Form\DataTransformer;
 
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\ORM\EntityManager;
 
class EntityToIdTransformer implements DataTransformerInterface
{
    private $em;
    private $entityClass;
 
    public function __construct(EntityManager $em, $entityClass)
    {
        $this->em = $em;
        $this->entityClass = $entityClass;
    }
 
    public function transform($entity)
    {
        if (null === $entity) {
            return "";
        }
 
        return $entity->getId();
    }
 
    public function reverseTransform($id)
    {
        if (!$id) {
            throw new TransformationFailedException(sprintf('Id cant be null'));
        }
        
        $entity = $this->em->getRepository($this->entityClass)->find($id);
 
        if (null === $entity) {
            throw new TransformationFailedException(sprintf('There is no entity of %s with id %s', $this->entityClass, $id));
        }
 
        return $entity;
    }
}