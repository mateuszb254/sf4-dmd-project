<?php

namespace App\Core\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * @Annotation
 */
class DoctrineEntityExistsByProperty extends Constraint
{
    public $message = "{{ entityName }} with {{ fieldName }} '{{ value }}' doesn't exist.";

    public $entityClassName;
    public $fieldName;

    public function __construct($options = null)
    {
        $options = array_replace([
            'fieldName' => 'id'
        ], $options);

        parent::__construct($options);

        if (!array_key_exists('entityClassName', $options)) {
            throw new MissingOptionsException(sprintf(
                'The option \'entityClassname\' must be set for constraint %s', __CLASS__), ['entityClassname']
            );
        }
    }
}
