<?php

namespace App\Form\DataTransformer;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;


class EntityToPropertyTransformer implements DataTransformerInterface
{
    private string $className;
    protected PropertyAccessor $accessor;

    public function __construct(
        private ObjectManager $em, 
        private string $class,
        private $primaryKey = 'id', 
        private $newTagPrefix = '__',)
    {
        $this->className = $class;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Transform entity to array
     *
     * @param mixed $entity
     * @return array
     */
    public function transform($entity)
    {dump('transform');
        dump($entity);
        $data = [];
        if (empty($entity)) {
            return null;
        }

        $text = (string) $entity;

        if ($this->em->contains($entity)) {
            $value = (string) $this->accessor->getValue($entity, $this->primaryKey);
        } else {
            $value = $this->newTagPrefix . $text;
        }

        $data[$value] = $text;

        return $data;
    }

    /**
     * Transform single id value to an entity
     *
     * @param string $value
     * @return mixed|null|object
     */
    public function reverseTransform($value)
    {dump('reverseTransform');
        dump($value);
        if (empty($value)) {
            return null;
        }

        // Add a potential new tag entry
        $tagPrefixLength = strlen($this->newTagPrefix);
        $cleanValue = substr($value, $tagPrefixLength);
        $valuePrefix = substr($value, 0, $tagPrefixLength);
        if ($valuePrefix === $this->newTagPrefix) {
            // In that case, we have a new entry
            $entity = new $this->className;
            $this->accessor->setValue($entity, 'name', $cleanValue);
            $this->em->persist($entity);
        } else {
            // We do not search for a new entry, as it does not exist yet, by definition
            try {
                $entity = $this->em->createQueryBuilder()
                    ->select('entity')
                    ->from($this->className, 'entity')
                    ->where('entity.'.$this->primaryKey.' = :id')
                    ->setParameter('id', $value)
                    ->getQuery()
                    ->getSingleResult();
            }
            catch (\Doctrine\ORM\UnexpectedResultException $ex) {
                // this will happen if the form submits invalid data
                throw new TransformationFailedException(sprintf('The choice "%s" does not exist or is not unique', $value));
            }
        }
dump($entity);
        if (!$entity) {
            return null;
        }

        return $entity;
    }
}