<?php


namespace Drupal\graphql_example\Plugin\Validation\Constraint;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueTagConstraintValidator extends ConstraintValidator {

  public function validate($items, Constraint $constraint) {
    foreach ($items as $item) {
      if(!$this->isUnique($item->value)) {
        $this->context->addViolation($constraint->notUnique, ['%value' => $item->value]);
      }
    }
  }

  public function isUnique($value) {
    $tag = \Drupal::entityQuery('blog_tag')
        ->condition('tag', $value, '=')
        ->execute();
    if(count($tag)) {
      return FALSE;
    }
    return TRUE;
  }
}
