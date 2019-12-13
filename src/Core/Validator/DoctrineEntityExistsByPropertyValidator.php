<?php

namespace App\Core\Validator;

use Doctrine\Common\Persistence\Mapping\MappingException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class DoctrineEntityExistsByPropertyValidator extends ConstraintValidator
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        try {
            $repository = $this->entityManager->getRepository($constraint->entityClassName);
        } catch (MappingException $exception) {
            throw new InvalidArgumentException(
                'Repository for ' . $constraint->entityClassName . ' couldn\'t be found.' . PHP_EOL .
                'Message: ' . $exception->getMessage()
            );
        }

        if (!$repository instanceof EntityRepository) {
            throw new \RuntimeException('Repository ' . get_class($repository) . ' must be an instance of EntityRepository');
        }

        $entity = $repository->findOneBy([$constraint->fieldName => $value]);

        if (!$entity instanceof $constraint->entityClassName) {
            $this->context->buildViolation($constraint->message)
                ->setParameters([
                    '{{ entityName }}' => $constraint->entityClassName,
                    '{{ value }}' => $value,
                    '{{ fieldName }}' => $constraint->fieldName,
                ])->addViolation();
        }
    }
}
