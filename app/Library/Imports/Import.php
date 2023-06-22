<?php

namespace App\Library\Imports;

use App\Imports\ShowTemplateMessageImport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Nyholm\Psr7\UploadedFile;

abstract class Import
{
    /**
     * The imported data.
     */
    protected array $data = [];

    /**
     * Create a new import instance.
     */
    public function __construct(protected string|UploadedFile $file)
    {
        //
    }

    /**
     * Read the file and extract the data.
     */
    public abstract function read(): array;

    public abstract function map(array $row): array;
}
