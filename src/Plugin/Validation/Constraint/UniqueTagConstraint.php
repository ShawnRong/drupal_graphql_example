<?php

namespace Drupal\graphql_example\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 *
 * @Constraint(
 *   id = "UniqueTag",
 *   label = @Translation("Unique Tag", context = "Validation"),
 * )
 */
class UniqueTagConstraint extends Constraint {
  public $notUnique = 'Tag %value in not unique';

  public function validatedBy() {
    return '\Drupal\graphql_example\Plugin\Validation\Constraint\UniqueTagConstraintValidator';
  }
}
