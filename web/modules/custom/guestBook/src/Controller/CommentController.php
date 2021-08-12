<?php

namespace Drupal\guestBook\Controller;

use Drupal\Core\Controller\ControllerBase;

class CommentController extends ControllerBase{

  public function content():array{
    return \Drupal::formBuilder()->getForm('Drupal\guestBook\Form\AddCommentForm');
  }

}
