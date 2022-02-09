<?php

namespace Src\Files;

interface FileUploadInterface
{
    public function getUploadFile($file): string;

    public function getUploadPath($file,$path): string;

    public function getUploadTempFile($file): string;

    public function saveFromTemp($file,$path);

}
