<?php

namespace Drupal\guestBook\Controller;

use Drupal\Core\Controller\ControllerBase;

class CommentController extends ControllerBase{


  public function content():array{
    $form = \Drupal::formBuilder()->getForm('Drupal\guestBook\Form\AddCommentForm');

    return $form;
  }

}
