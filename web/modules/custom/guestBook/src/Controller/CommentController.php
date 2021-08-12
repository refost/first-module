<?php

namespace Drupal\guestBook\Controller;

use Drupal\Core\Controller\ControllerBase;

class CommentController extends ControllerBase{

  /**
   * Create table with cats.
   */
  public function table():array {
    $query = \Drupal::database()->select('guest_book', 'comment');
    $query->fields('comment', ['name', 'email', 'phone', 'comment', 'date']);
    $results = $query->execute()->fetchAll();
    $commment = [];
    foreach ($results as $data) {
//      $fid = $data->image;
//      $file = File::load($fid);
//      $path = $file->getFileUri();
//
//      $image_render = [
//        '#theme' => 'image_style',
//        '#style_name' => 'thumbnail',
//        '#uri' => $path,
//      ];

      $commment[] = [
        'name' => $data->name,
        'email' => $data->email,
        'phone' => $data->phone,
        'comment' => $data->comment,
//        'avatar' => ['data' => $image_render],
//        'avatar' => ['data' => $image_render],
        'date' => date('Y-m-d', $data->date),
      ];
    }

    if ($commment != NULL) {
      krsort($commment);
    }

    var_dump($commment);

    return $commment;
  }


  public function content():array{
    $form = \Drupal::formBuilder()->getForm('Drupal\guestBook\Form\AddCommentForm');

    $data = $this->table();

    return [
      '#theme' => 'guestBook_template',
      '#form' => $form,
      '#data' => $data,
    ];
  }



}
