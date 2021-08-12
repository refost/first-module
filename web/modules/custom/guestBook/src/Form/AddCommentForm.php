<?php

namespace Drupal\guestBook\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class AddCommentForm extends FormBase {

  public function getFormId(): string {
    return 'form_cats';
  }

  /**
   * Build form for cat info.
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['name-valid'] = [
      '#type' => 'markup',
      '#markup' => '<div id="name_message"></div>',
    ];
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your name:'),
      '#description' => $this->t('min length - 2 symbols, min - 100'),
      '#required' => TRUE,
      '#maxlength' => 100,
      '#ajax' => [
        'callback' => '::validName',
        'event' => 'change',
      ],
    ];

    $form['email-valid'] = [
      '#type' => 'markup',
      '#markup' => '<div id="email_message"></div>',
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Your email:'),
      '#description' => $this->t('your@mail.com'),
      '#required' => TRUE,
      '#pattern' => '^[\w+]{2,100}@([\w+]{2,30})\.[\w+]{2,30}$',
      '#ajax' => [
        'callback' => '::validEmail',
        'event' => 'change',
      ],
    ];

    $form['email-valid'] = [
      '#type' => 'markup',
      '#markup' => '<div id="phone_message"></div>',
    ];
    $form['telephone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Your phone:'),
      '#placeholder' => $this->t('+000-00-000-0000'),
      '#required' => TRUE,
//      '#pattern' => '^[-_aA-zZ]{2,30}@([a-z]{2,10})\.[a-z]{2,10}$',
//      '#ajax' => [
//        'callback' => '::validSymb',
//        'event' => 'keyup',
//      ],
    ];

    $form['telephone'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Your comment'),
      '#required' => TRUE,
//      '#pattern' => '^[-_aA-zZ]{2,30}@([a-z]{2,10})\.[a-z]{2,10}$',
//      '#ajax' => [
//        'callback' => '::validSymb',
//        'event' => 'keyup',
//      ],
    ];

    $form['avatar'] = [
      '#type' => 'managed_file',
      '#title' => t('Your avatar'),
      '#required' => TRUE,
      '#upload_location' => 'public://images/avatars/',
      '#upload_validators' => [
        'file_validate_extensions' => ['png jpg jpeg'],
        'file_validate_size' => [2097152],
      ],
    ];

    $form['picture'] = [
      '#type' => 'managed_file',
      '#title' => t('Picture to comment'),
      '#required' => TRUE,
      '#upload_location' => 'public://images/pictures/',
      '#upload_validators' => [
        'file_validate_extensions' => ['png jpg jpeg'],
        'file_validate_size' => [5242880],
      ],
    ];

    $form['massage'] = [
      '#type' => 'markup',
      '#markup' => '<div id="result_message"></div>',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add comment'),
//      '#ajax' => [
//        'callback' => '::setMessage',
//        'event' => 'click',
//      ],
    ];

    return $form;
  }

  public function validName(array &$form, FormStateInterface $form_state) {

  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

  }
}
