<?php

namespace Drupal\guestBook\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;
use Drupal\Core\Url;
class CommentController extends ControllerBase{


  /**
   * Create table with cats.
   */
  public function table():array {
    $query = \Drupal::database()->select('guest_book', 'comment');
    $query->fields('comment', ['id','name', 'email', 'phone', 'comment', 'date', 'image' , 'avatar']);
    $results = $query->execute()->fetchAll();
    $commment = [];
    foreach ($results as $data) {
      $image = $this->isImage($data->image);
      $avatar = $this->isImage($data->avatar);

      $url_delete = Url::fromRoute('guestBook.delete', ['id' => $data->id], []);
      $linkDelete = $this->linkCreate('Delete', $url_delete);

      $url_edit = Url::fromRoute('guestBook.edit', ['id' => $data->id], []);
      $linkEdit = $this->linkCreate('Edit', $url_edit);

      $commment[] = [
        'name' => $data->name,
        'email' => $data->email,
        'phone' => $data->phone,
        'comment' => $data->comment,
        'image' => ['data' => $image],
        'avatar' => ['data' => $avatar],
        'date' => date('Y-m-d', $data->date),
        'delete' =>  $linkDelete,
        'edit' =>  $linkEdit,
      ];
    }

    if ($commment != NULL) {
      krsort($commment);
    }

    var_dump($image);

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

  public function isImage($image){
    if ($image != NULL) {
      $file = File::load($image);
      $path = $file->getFileUri();

      $image_render = [
        '#theme' => 'image',
        '#uri' => $path,
        '#attributes' => [
          'alt' => 'picture',
          'width' => 250,
          'height' => 250
        ]
      ];
    } else {
      $image_render = NULL;
    }
    return $image_render;
  }


  public function linkCreate($title, $link):array {
    return [
      '#type' => 'link',
      '#title' => $title,
      '#url' => $link,
//      '#options' => [
//        'attributes' => [
//          'class' => ['use-ajax'],
//          'data-dialog-type' => 'modal',
//        ],
//      ],
//      '#attached' => ['library' => ['core/drupal.dialog.ajax']],
    ];
  }

}
