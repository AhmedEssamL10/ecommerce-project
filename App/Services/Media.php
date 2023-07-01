<?php

namespace App\Services;

class Media
{
    private array $file;
    private string $fileType;
    private string $fileExtension;
    private float $fileSize;
    private array $errors = [];
    private string $fileName;
    /**
     * Get the value of file
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @return  self
     */
    public function setFile($file)
    {
        $this->file = $file;
        $array = explode('/', $this->file['type']); // ['image','png']
        $this->fileType = $array[0];
        $this->fileExtension = $array[1];
        $this->fileSize = $this->file['size'];
        return $this;
    }



    /**
     * Get the value of fileType
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * Get the value of fileExtension
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    /**
     * Get the value of fileSize
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }


    /**
     * Get the value of errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function getError(string $error): ?string
    {
        return $this->errors[$error] ?? NULL;
    }

    public function size(int $maxSize): self
    {
        if ($this->fileSize > $maxSize) {
            $this->errors[__FUNCTION__] = 'Max Size ' . $maxSize . ' Bytes';
        }
        return $this;
    }

    public function extension(array $avialableExtensions): self
    {
        if (!in_array($this->fileExtension, $avialableExtensions)) {
            $this->errors[__FUNCTION__] = 'Available Extensions Are: ' . implode(',', $avialableExtensions);
        }
        return $this;
    }

    public function upload(string $pathTo): bool // get image from temp name to my storage
    {
        $this->fileName = uniqid() . '.' . $this->fileExtension;
        $pathTo .= $this->fileName; // img/users/sdfghjhgfdsdf.jpg
        return move_uploaded_file($this->file['tmp_name'], $pathTo);
    }

    public function delete(string $path): bool
    {
        if (file_exists($path)) {
            unlink($path);
            return true;
        }
        return false;
    }

    /**
     * Get the value of fileName
     */
    public function getFileName()
    {
        return $this->fileName;
    }
}
