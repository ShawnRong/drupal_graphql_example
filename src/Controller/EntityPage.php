<?php


namespace Drupal\graphql_example\Controller;



class EntityPage {

  /**
   * Generate a render array with our templated content.
   *
   * @return array
   *   A render array.
   */
  public function description() {
    $template_path = $this->getDescriptionTemplatePath();
    $template = file_get_contents($template_path);
    $build = [
      'description' => [
        '#type' => 'inline_template',
        '#template' => $template,
        '#context' => $this->getDescriptionVariables(),
        '#attached' => [
          'library' => [
            'graphql_example/graphql_example.library',
          ]
        ]
      ],
    ];
    return $build;
  }

  /**
   * Get full path to the template.
   *
   * @return string
   *   Path string.
   */
  protected function getDescriptionTemplatePath() {
    return drupal_get_path('module', $this->getModuleName()) . "/templates/description.html.twig";
  }

  /**
   * Variables to act as context to the twig template file.
   *
   * @return array
   *   Associative array that defines context for a template.
   */
  protected function getDescriptionVariables() {
    $variables = [
      'module' => $this->getModuleName(),
    ];
    return $variables;
  }

  /**
   * {@inheritdoc}
   */
  public function getModuleName() {
    return 'graphql_example';
  }
}
