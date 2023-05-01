<?php

namespace App\Form\DataTransformer;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Form\Exception\TransformationFailedException;


class EntityToPropertyTransformer implements DataTransformerInterface
{
    private string $className;
    protected PropertyAccessor $accessor;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security $security, 
        string $class,
        private $primaryKey = 'id', 
        private $newTagPrefix = '__',)
    {
        $this->className = $class;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }


    public function transform($entity): ?array
    {
        $data = [];
        if (empty($entity)) {
            return null;
        }

        $text = (string) $entity;

        if ($this->entityManager->contains($entity)) {
            $value = (string) $this->accessor->getValue($entity, $this->primaryKey);
        } else {
            $value = $this->newTagPrefix . $text;
        }

        $data = ['id' => $value, 'name' => $text];

        return $data;
    }

    /**
     * Transform single id value to an entity
     *
     * @param string $value
     * @return mixed|null|object
     */
    public function reverseTransform($value)
    {
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
            /** @var User $user */
            $user = $this->security->getUser();
            $this->accessor->setValue($entity, 'name', $cleanValue);
            $this->accessor->setValue($entity, 'user', $user);
            $this->entityManager->persist($entity);
        } else {
            // We do not search for a new entry, as it does not exist yet, by definition
            try {
                $entity = $this->entityManager->createQueryBuilder()
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

        if (!$entity) {
            return null;
        }

        return $entity;
    }
}