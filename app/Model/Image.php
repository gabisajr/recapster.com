<?php

namespace App\Model;

use App\ImageManager;
use Illuminate\Database\Eloquent\Model;
use Exception;
use ImageOptimizer\OptimizerFactory;
use Intervention\Image\Image as InterventionImage;

/**
 * Class Image
 * @package App\Model
 * @property int     $id
 * @property string  $path
 * @property int     $width
 * @property int     $height
 * @property int     $parent_id
 * @property boolean $optimised
 * @property string  $modifier
 * @property int     $created_at
 * @property int     $updated_at
 */
class Image extends Model {

  public function childs() {
    return $this->hasMany('App\Model\Image', 'parent_id');
  }

  /** сохраняем оригинальные размеры */
  public function saveSizes() {
    if ($this->exists && (is_null($this->width) || is_null($this->height))) {
      $path = public_path($this->path);
      if (file_exists($path)) {
        $image = ImageManager::instance()->make($path);
        $this->width = $image->width();
        $this->height = $image->height();
        $this->save();
      }
    }

    return $this;
  }

  /** вписать в заданные размеры
   * @param int $width
   * @param int $height
   * @return Image
   * @throws Exception
   */
  public function fit(int $width, int $height) {
    if (!$this->exists) return $this;

    if (!file_exists(public_path($this->path))) return $this;

    if ($width <= 0) {
      throw new Exception('Ширина должна быть больше 0');
    }

    if ($height <= 0) {
      throw new Exception('Высота должна быть больше 0');
    }

    $this->saveSizes()->optimise();

    //условия при котором можно вернуть оригинал: если ширина и высота картинки совпадают с задаными
    if ($this->width == $width && $this->height == $height) return $this;

    $modifier = "f"; //fit
    $modifier .= is_null($width) ? "_" : $width;
    $modifier .= "x";
    $modifier .= is_null($height) ? "_" : $height;

    //поиск в базе
    $ormImage = self::query()
      ->where('modifier', '=', $modifier)
      ->where('parent_id', '=', $this->id)
      ->first();

    if ($ormImage) return $ormImage->optimise();

    //создаем копию, задаем размеры и сохраняем в файловую систему
    $path = public_path($this->path);

    /** @var InterventionImage $image */
    $image = ImageManager::instance()->make($path);
    $image->fit($width, $height, function ($constraint) {
      $constraint->upsize();
    });

    //сохраняем ресайзнутую картинку в файловую систему
    $dir = pathinfo($this->path, PATHINFO_DIRNAME);
    $ext = mb_strtolower(pathinfo($this->path, PATHINFO_EXTENSION));
    $name = pathinfo($this->path, PATHINFO_FILENAME);
    $newPath = "{$dir}/{$name}-{$modifier}.{$ext}";
    $image->save(public_path($newPath));

    //сохраняем ресайзнутую картинку в базу
    $ormImage = new self;
    $ormImage->path = $newPath;
    $ormImage->width = $width;
    $ormImage->height = $height;
    $ormImage->parent_id = $this->id;
    $ormImage->modifier = $modifier;
    $ormImage->save();
    return $ormImage->optimise();
  }

  public function resize(int $width = null, int $height = null) {
    if (!$this->exists) return $this;

    if (!file_exists(public_path($this->path))) return $this;

    if (is_null($width) && is_null($height)) throw new Exception("Хотябы один из параметров width и height должен быть числом");

    if (!is_null($width) && $width <= 0) throw new Exception('Ширина должна быть больше 0');

    if (!is_null($height) && $height <= 0) throw new Exception('Высота должна быть больше 0');

    $this->saveSizes()->optimise();

    //задана только ширина и она совпадает с шириной оригинала, то возвращаем себя
    if (is_null($height) && $width == $this->width) return $this;

    //задана только высота и она совпадает с высотой оригинала, то возвращаем себя
    if (is_null($width) && $height == $this->height) return $this;

    //заданы и ширина и высота, и они совпадают с оригинальными, то возвращаем себя
    if ($width == $this->width && $height == $this->height) return $this;

    $modifier = "r"; //resize
    $modifier .= is_null($width) ? "_" : $width;
    $modifier .= "x";
    $modifier .= is_null($height) ? "_" : $height;

    //поиск в базе
    $ormImage = self::query()
      ->where('modifier', '=', $modifier)
      ->where('parent_id', '=', $this->id)
      ->first();

    if ($ormImage) return $ormImage->optimise();

    //создаем копию, задаем размеры и сохраняем в файловую систему
    $path = public_path($this->path);

    /** @var InterventionImage $image */
    $image = ImageManager::instance()->make($path);
    $image->resize($width, $height, function ($constraint) {
      $constraint->aspectRatio();
      $constraint->upsize();
    });

    //сохраняем ресайзнутую картинку в файловую систему
    $dir = pathinfo($this->path, PATHINFO_DIRNAME);
    $ext = mb_strtolower(pathinfo($this->path, PATHINFO_EXTENSION));
    $name = pathinfo($this->path, PATHINFO_FILENAME);
    $newPath = "{$dir}/{$name}-{$modifier}.{$ext}";
    $image->save(public_path($newPath));

    //сохраняем ресайзнутую картинку в базу
    $ormImage = new self;
    $ormImage->path = $newPath;
    $ormImage->width = $image->width();
    $ormImage->height = $image->height();
    $ormImage->modifier = $modifier;
    $ormImage->parent_id = $this->id;
    $ormImage->save();
    return $ormImage->optimise();
  }

  /** оптимизация изображения */
  public function optimise() {

    if (env('APP_ENV') == 'production') return $this;

    if (!$this->optimised) {

      $factory = new OptimizerFactory([
        'ignore_errors' => false,
        'jpegtran_bin'  => 'D:/image-optimizer/jpegtran/jpegtran.exe',
        'pngquant_bin'  => 'D:/image-optimizer/pngquant/pngquant.exe',
        'optipng_bin'   => 'D:/image-optimizer/optipng/optipng.exe',
        'pngcrush_bin'  => 'D:/image-optimizer/pngcrush/pngcrush_1_8_11_w64.exe',
        'advpng_bin'    => 'D:/image-optimizer/advpng/advpng.exe',
      ]);
      $optimizer = $factory->get();

      $filepath = public_path($this->path);
      $optimizer->optimize($filepath);

      $this->optimised = true;
      $this->save();
    }

    return $this;
  }

}
