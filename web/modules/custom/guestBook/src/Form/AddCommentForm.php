<?php

namespace Drupal\guestBook\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

class AddCommentForm extends FormBase {

  public function getFormId(): string {
    return 'form_add_comment';
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
      '#pattern' => '^[\w+\s]{2,100}$',
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

    $form['phone-valid'] = [
      '#type' => 'markup',
      '#markup' => '<div id="phone_message"></div>',
    ];
    $form['phone'] = [
      '#type' => 'tel',
      '#title' => $this->t('Your phone:'),
      '#placeholder' => $this->t('000 00 000 0000'),
      '#pattern' => '^[0-9]{12}$',
      '#ajax' => [
        'callback' => '::validPhone',
        'event' => 'change',
      ],
    ];

    $form['comment-valid'] = [
      '#type' => 'markup',
      '#markup' => '<div id="comment_message"></div>',
    ];
    $form['comment'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Your comment'),
      '#required' => TRUE,
      '#maxlength' => 1000,
    ];

    $form['avatar'] = [
      '#type' => 'managed_file',
      '#title' => t('Your avatar'),
      '#upload_location' => 'public://images/avatars/',
      '#upload_validators' => [
        'file_validate_extensions' => ['png jpg jpeg'],
        'file_validate_size' => [2097152],
      ],
    ];

    $form['picture'] = [
      '#type' => 'managed_file',
      '#title' => t('Picture to comment'),
      '#upload_location' => 'public://images/pictures/',
      '#upload_validators' => [
        'file_validate_extensions' => ['png jpg jpeg'],
        'file_validate_size' => [5242880],
      ],
    ];

    $form['message'] = [
      '#type' => 'markup',
      '#markup' => '<div id="result_message"></div>',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add comment'),
      '#ajax' => [
        'callback' => '::setMessage',
        'event' => 'click',
      ],
    ];

    return $form;
  }

  public function validName(array &$form, FormStateInterface $form_state) {
    $regular = '/^[\w+\s]{2,100}$/';
    $name = $form_state->getValue('name');

    $response = new AjaxResponse();
    if (!preg_match($regular, $name)) {
      $response->AddCommand(
        new HtmlCommand(
          '#name_message',
          '<div class="invalid-message">'
          . $this->t('You name must be longer than 2 symbols')
        )
      );
      $response->addCommand(
        new CssCommand('#edit-name', ['border-color' => 'red'])
      );
    } else {
      $response->AddCommand(
        new HtmlCommand(
          '#name_message',
          '<div class="correct-message">'
          . $this->t('You name is correct')
        )
      );
      $response->addCommand(
        new CssCommand('#edit-name', ['border-color' => 'green'])
      );
    }
    return $response;
  }

  public function validEmail(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');
    $regular = '/^[\w+]{2,100}@([\w+]{2,30})\.[\w+]{2,30}$/';

    $response = new AjaxResponse();
    if (!preg_match($regular, $email)) {
      $response->AddCommand(
        new HtmlCommand(
          '#email_message',
          '<div class="invalid-message">'
          . $this->t('Email must be like this "yourname@mail.com"')
        )
      );
      $response->addCommand(
        new CssCommand('#edit-email', ['border-color' => 'red'])
      );
    } else {
      $response->AddCommand(
        new HtmlCommand(
          '#email_message',
          '<div class="correct-message">'
          . $this->t('You email is correct')
        )
      );
      $response->addCommand(
        new CssCommand('#edit-email', ['border-color' => 'green'])
      );
    }
    return $response;
  }

  public function validPhone(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('phone');
    $regular = '/^[0-9]{12}$/';

    $response = new AjaxResponse();
    if (!preg_match($regular, $email)) {
      $response->AddCommand(
        new HtmlCommand(
          '#phone_message',
          '<div class="invalid-message">'
          . $this->t('Your number must have 12 numbers')
        )
      );
      $response->addCommand(
        new CssCommand('#edit-phone', ['border-color' => 'red'])
      );
    } else {
      $response->AddCommand(
        new HtmlCommand(
          '#phone_message',
          '<div class="correct-message">'
          . $this->t('You phone is correct')
        )
      );
      $response->addCommand(
        new CssCommand('#edit-phone', ['border-color' => 'green'])
      );
    }
    return $response;
  }

  public function setMessage(array &$form, FormStateInterface $form_state) {

    $response = new AjaxResponse();
    if ($form_state->hasAnyErrors()) {
      $response->AddCommand(
        new HtmlCommand(
          '#result_message',
          '<div class="invalid-message">'
          . $this->t('Please enter correct information.')
        )
      );
    } else {
      $response->AddCommand(
        new HtmlCommand(
          '#result_message',
          '<div class="correct-message">'
          . $this->t('Thanks for your comment')
        )
      );
    }
    \Drupal::messenger()->deleteAll();
    return $response;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $picture = $form_state->getValue('picture');
    $avatar = $form_state->getValue('avatar');

    if ($picture != NULL) {
      $file = File::load($picture[0]);
      $file->setPermanent();
      $file->save();
    }

    \Drupal::database()
      ->insert('guest_book')
      ->fields([
        'name' => $form_state->getValue('name'),
        'email' => $form_state->getValue('email'),
        'phone' => $form_state->getValue('phone'),
        'comment' => $form_state->getValue('comment'),
        'avatar' => $avatar[0],
        'image' => $picture[0],
        'date' => time(),
      ])
      ->execute();
  }
}

