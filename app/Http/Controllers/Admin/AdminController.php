<?php

namespace App\Http\Controllers\Admin;

use App\Model\Image;
use App\Model\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;

class AdminController extends Controller {

  private $uploadDir = "uploads";

  public function __construct() {
    $this->middleware('auth:admin');

    View::share('sidebarActive', null);
  }

  public function uploadImage(Model $model, string $fieldName = 'image') {

    if (!$model->exists) return;

    $file = request()->file($fieldName);
    if ($file) {
      $destinationPath = $this->uploadDir;
      $name = uniqid() . '.' . mb_strtolower($file->getClientOriginalExtension());
      $file->move($destinationPath, $name);

      //create new image
      $image = new Image;
      $image->path = "/" . $destinationPath . "/" . $name;
      if ($image->save()) {

        //delete old image
        if ($model->{$fieldName}) $model->{$fieldName}->delete();

        $model->{$fieldName}()->associate($image);
        $model->save();
      }
    }
  }

  public function uploadImages(Model $model) {

    $pivotTable = $model->images()->getTable();
    $maxSort = $model->images()->max("$pivotTable.sort");
    if ($maxSort) {
      $maxSort++;
    } else {
      $maxSort = 0;
    }

    $uploadedCount = 0;
    $files = request()->file('images', []);
    if ($files) {
      foreach ($files as $i => $file) {
        $destinationPath = $this->uploadDir;
        $name = uniqid() . '.' . mb_strtolower($file->getClientOriginalExtension());
        $file->move($destinationPath, $name);

        //create new image
        $image = new Image;
        $image->path = "/" . $destinationPath . "/" . $name;
        if ($image->save()) {
          $model->images()->save($image, ['sort' => $maxSort + $i]);
          $uploadedCount++;
        }
      }
    }

    return $uploadedCount;
  }

  public function attachFiles(Model $model) {
    $pivotTable = $model->files()->getTable();
    $maxSort = $model->files()->max("$pivotTable.sort");
    if ($maxSort) {
      $maxSort++;
    } else {
      $maxSort = 0;
    }

    $files = request()->input('file', []);

    //prepare sync array
    $data = [];
    foreach ($files as $i => $fileId) {
      $data[$fileId] = [
        'sort' => $maxSort + $i,
      ];
    }

    $model->files()->sync($data);
  }

  public function attachVideos(Model $model) {
    $pivotTable = $model->videos()->getTable();
    $maxSort = $model->videos()->max("$pivotTable.sort");
    if ($maxSort) {
      $maxSort++;
    } else {
      $maxSort = 0;
    }

    $videos = request()->input('video', []);
    $arrId = array_get($videos, 'id', []);
    $arrTitle = array_get($videos, 'title', []);
    $arrVendor = array_get($videos, 'vendor', []);
    $arrVendorId = array_get($videos, 'vendor_id', []);
    $arrThumbnail = array_get($videos, 'thumbnail', []);

    $syncVideos = [];
    $i = 0;
    foreach ($arrId as $key => $id) {
      /** @var Video $video */
      $video = Video::findOrNew($id);
      $video->title = array_get($arrTitle, $key);
      $video->vendor = array_get($arrVendor, $key);
      $video->vendor_id = array_get($arrVendorId, $key);
      $video->thumbnail = array_get($arrThumbnail, $key);
      $video->save();

      $syncVideos[$video->id] = [
        'sort' => $maxSort + $i++,
      ];
    }

    $model->videos()->sync($syncVideos);
  }

  public function sortImages(Request $request) {

    //request data
    $modelName = $request->input('model');
    $modelId = $request->input('id');
    $sortArr = $request->input('sort', []);

    if (!$modelName || !$modelId || !$sortArr || !is_array($sortArr) || !count($sortArr)) {
      abort(422, "Не верных формат запроса");
    }

    $class = '\\App\\Model\\' . ucfirst($modelName);
    if (!class_exists($class)) abort(404, "Класс модели не найден: $modelName");
    $model = $class::find($modelId);
    if (!$model) abort(404, "Объект не найден: $modelId");

    foreach ($sortArr as $sort => $imageId) {
      $model->images()->updateExistingPivot($imageId, ['sort' => $sort]);
    }
  }

  public function sortVideos(Request $request) {

    //request data
    $modelName = $request->input('model');
    $modelId = $request->input('id');
    $sortArr = $request->input('sort', []);

    if (!$modelName || !$modelId || !$sortArr || !is_array($sortArr) || !count($sortArr)) {
      abort(422, "Не верных формат запроса");
    }

    $class = '\\App\\Model\\' . ucfirst($modelName);
    if (!class_exists($class)) abort(404, "Класс модели не найден: $modelName");
    $model = $class::find($modelId);
    if (!$model) abort(404, "Объект не найден: $modelId");

    foreach ($sortArr as $sort => $videoId) {
      $model->videos()->updateExistingPivot($videoId, ['sort' => $sort]);
    }
  }

}
