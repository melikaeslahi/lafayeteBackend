<?php

namespace App\Http\Services\Image;

 

class ImageToolsService
{

    protected $image;
    protected $exclusiveDirectory;
    protected $imageDirectory;
    protected $imageName;
    protected $imageFormated;
    protected $finalImageDirectory;
    protected $finalImageName;


    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getExclusiveDirectory()
    {
        return  $this->exclusiveDirectory;
    }
    public function setExclusiveDirectory($exclusiveDirectory)
    {
        $this->exclusiveDirectory = trim($exclusiveDirectory, '/\\');
    }

    public function getImageDirectory()
    {
        return  $this->imageDirectory;
    }
    public function setImageDirectory($imageDirectory)
    {
        $this->imageDirectory = trim($imageDirectory, '/\\');;
    }

    public function getImageName()
    {
        return  $this->imageName;
    }
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    public function setCurrentImageName()
    {
        return !empty($this->imageName) ? $this->setImageName(pathinfo($this->image->getClientOriginalName(), PATHINFO_FILENAME)) : false;
        // getClientOriginalName() = $_FILES['image']['name']
    }

    public function getImageFormated()
    {
        return  $this->imageFormated;
    }
    public function setImageFormated($imageFormated)
    {
        $this->imageFormated = $imageFormated;
    }
    public function getFinalImageDirectory()
    {
        return  $this->finalImageDirectory;
    }
    public function setFinalImageDirectory($finalImageDirectory)
    {
        $this->finalImageDirectory = $finalImageDirectory;
    }

    public function getFinalImageName()
    {
        return  $this->finalImageName;
    }
    public function setFinalImageName($finalImageName)
    {
        $this->finalImageName = $finalImageName;
    }


    protected function checkDirectory($imageDirectory)
    {
        dd( mkdir($imageDirectory, 0755, true));

        if (!file_exists($imageDirectory)) {
            mkdir($imageDirectory,0755, true);
        }
    }
    public function getImageAddress()
    {
        return $this->finalImageDirectory . DIRECTORY_SEPARATOR . $this->finalImageName;
    }

    protected function provider()
    {

        // set proprties 
        $this->getImageDirectory() ?? $this->setImageDirectory(date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR .  date('d'));
        $this->getImageName() ?? $this->setImageName(time());
        $this->getImageFormated() ?? $this->setImageFormated($this->image->extension());


        //set final image directory
        $finalImageDirectory = empty($this->getExclusiveDirectory()) ? $this->getImageDirectory() : $this->getExclusiveDirectory() . DIRECTORY_SEPARATOR . $this->getImageDirectory();
        $this->setFinalImageDirectory($finalImageDirectory);

        //set finanl image name
        $this->setFinalImageName($this->getImageName() . '.' . $this->getImageFormated());

        //check and create final image directory

        $this->checkDirectory($this->getFinalImageDirectory());
    }
}
