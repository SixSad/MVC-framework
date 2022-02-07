<?php

namespace Src\Files;

interface FileUploadInterface
{
    public function getUploadPath(): string;

    public function saveFromTemp(string $uploadFolder);

}
